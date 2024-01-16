<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Deposit\CapturePaypalOrder;
use App\Models\Core\Notification;
use App\Models\Core\User;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Services\Api\PaypalAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaypalController extends Controller
{
    public function returnUrl(Request $request)
    {
        $paypalApi = new PaypalAPI();
        $response = $paypalApi->showOrder($request->get('token'));

        if ($response[RESPONSE_STATUS_KEY]) {
            $responseCurrency = $response[RESPONSE_DATA_KEY]['purchase_units'][0]['amount']['currency_code'];

            $walletTransaction = WalletTransaction::where('payment_txn_id', $response[RESPONSE_DATA_KEY]['id'])
                ->where('payment_method', PAYMENT_METHOD_PAYPAL)
                ->where('txn_type', TRANSACTION_TYPE_DEPOSIT)
                ->first();

            abort_if($walletTransaction, 404);

            $wallet = Wallet::where('currency_symbol', $responseCurrency)
                ->where('user_id', Auth::id())->first();

            $parameters = [
                'user_id' => Auth::id(),
                'wallet_id' => $wallet->id,
                'status' => PAYMENT_STATUS_PENDING,
                'txn_type' => TRANSACTION_TYPE_DEPOSIT,
                'ref_id' => Str::uuid()->toString(),
                'payment_txn_id' => $response[RESPONSE_DATA_KEY]['id'],
                'payment_method' => PAYMENT_METHOD_PAYPAL,
                'currency_symbol' => $wallet->currency_symbol,
                'amount' => $response[RESPONSE_DATA_KEY]['purchase_units'][0]['amount']['value'],
            ];

            if ($walletTransaction = WalletTransaction::create($parameters)) {

                CapturePaypalOrder::dispatchNow($response[RESPONSE_DATA_KEY]['id']);

                $notification = [
                    'user_id' => auth()->id(),
                    'message' => __('Your deposit request of :currency :amount has been approved by paypal.', [
                        'currency' => $walletTransaction->currency_symbol,
                        'amount' => $walletTransaction->amount,
                    ]),
                    'link' => route('wallets.deposits.show', [
                        'wallet' => $walletTransaction->currency_symbol,
                        'deposit' => $walletTransaction->id
                    ])
                ];

                Notification::create($notification);

                $data['url'] = route('wallets.deposits.show', [
                    'wallet' => $walletTransaction->currency_symbol,
                    'deposit' => $walletTransaction->id
                ]);
                $data['message'] = __('The payment has been paid successfully. :url', [
                    'url' => '<a href="' . $data['url'] . '">' . __('Click here to view deposit details.') . '</a>'
                ]);
                $data['title'] = __('Payment Success');
                $data['type'] = 'success';

                return view('deposits.user.paypal.show', $data);
            }
        }

        $notification = [
            'user_id' => auth()->id(),
            'message' => __('Your deposit request of :currency :amount has been failed by paypal.', [
                'currency' => $walletTransaction->currency_symbol,
                'amount' => $walletTransaction->amount,
            ]),
            'link' => route('wallets.deposits.show', [
                'wallet' => $walletTransaction->currency_symbol,
                'deposit' => $walletTransaction->id
            ])
        ];
        Notification::create($notification);
        abort(404);
    }

    public function cancelUrl(Request $request)
    {
        $data['url'] = route('wallets.index');
        $data['message'] = __('The payment has been cancelled. :url', ['url' => '<a href="' . $data['url'] . '">' . __('Click here to view wallets.') . '</a>']);
        $data['title'] = __('Payment Canceled');
        $data['type'] = 'danger';

        return view('deposits.user.paypal.show', $data);
    }

    public function webhookPaypal(Request $request)
    {
        $paypalApi = new PaypalAPI();
        $response = $paypalApi->verifyWebhookSignature($request);

        if( !$response[RESPONSE_STATUS_KEY] ||  $response[RESPONSE_DATA_KEY]['verification_status'] !== "SUCCESS" ) {
            return false;
        }

        $requestData = $request->all();

        if ( $requestData['event_type'] === PAYPAL_CHECKOUT_ORDER_APPROVED ) {
            $this->paypalCheckoutApprovedEvent($requestData);
        } else if( in_array($requestData['event_type'], paypal_payout_webhook_type() ) ) {
            $this->paypalPayoutEvents($requestData);
        }
    }

    public function paypalCheckoutApprovedEvent($response) {
        $walletTransaction = WalletTransaction::where('payment_txn_id', $response['resource']['id'])
            ->where('payment_method', PAYMENT_METHOD_PAYPAL)
            ->where('txn_type', TRANSACTION_TYPE_DEPOSIT)
            ->first();

        if($walletTransaction) {
            return false;
        }

        $currency = $response['resource']['purchase_units'][0]['amount']['currency_code'];
        $referenceID = $response['resource']['purchase_units'][0]['reference_id'];
        $userID = explode('_', $referenceID);
        $userID = $userID[0];
        $wallet = Wallet::where('currency_symbol', $currency)
            ->where('user_id', $userID)->first();

        if(!$wallet) {
            return false;
        }

        $parameters = [
            'user_id' => $userID,
            'wallet_id' => $wallet->id,
            'status' => PAYMENT_STATUS_PENDING,
            'txn_type' => TRANSACTION_TYPE_DEPOSIT,
            'ref_id' => Str::uuid()->toString(),
            'payment_txn_id' => $response['resource']['id'],
            'payment_method' => PAYMENT_METHOD_PAYPAL,
            'currency_symbol' => $wallet->currency_symbol,
            'amount' => $response['resource']['purchase_units'][0]['amount']['value'],
        ];

        if ( WalletTransaction::create($parameters) ) {
            CapturePaypalOrder::dispatchNow( $response['resource']['id'] );
        }
    }

    public function paypalPayoutEvents($response) {
        if($response['event_type'] === PAYPAL_PAYMENT_PAYOUTS_ITEM_SUCCEEDED ) {
            $this->paypalPayoutCompleteEvent($response);
        }
        elseif ( in_array(strtoupper($response['event_type']), paypal_payout_webhook_type()) ) {
            $this->paypalPayoutVoidedEvent($response);
        }
    }

    public function paypalPayoutCompleteEvent($response) {
        $walletTransaction = WalletTransaction::where('payment_txn_id', $response['resource']['payout_batch_id'])
            ->where('payment_method', PAYMENT_METHOD_PAYPAL)
            ->where('currency_symbol', $response['resource']['payout_item']['amount']['currency'])
            ->where('status', PAYMENT_STATUS_PENDING)
            ->with('currency')
            ->first();

        if( !$walletTransaction ) {
            return false;
        }

        $walletTransaction->update([
            'payment_txn_id' => $response['resource']['transaction_id'],
            'status' => PAYMENT_STATUS_COMPLETED
        ]);

        $superAdmin = User::where('is_super_admin', ACTIVE)->first();
        $date = now();
        if (!empty($superAdmin) && ($walletTransaction->system_fee > 0) ) {
            $systemWallet = Wallet::where('currency_symbol', $walletTransaction->currency_symbol)
                ->where('user_id', $superAdmin->id)
                ->first();

            $systemWallet->increment('balance', $walletTransaction->system_fee);

            $systemWallet->walletTransactions()->create([
                'user_id' => $systemWallet->user_id,
                'txn_type' => TRANSACTION_TYPE_SYSTEM_FEE,
                'currency_symbol' => $systemWallet->currency_symbol,
                'amount' => $walletTransaction->system_fee,
                'status' => PAYMENT_STATUS_COMPLETED,
                'ref_id' => Str::uuid()->toString(),
            ]);

            $notifications[] = [
                'user_id' => $systemWallet->user_id,
                'message' => __(':amount :currency  has been credited to your wallet as profit (user withdrawal fee)',
                    [
                        'currency' => $walletTransaction->currency_symbol,
                        'amount' => $walletTransaction->system_fee,
                    ]),
                'link' => route('wallets.deposits.show', [
                    'wallet' => $walletTransaction->currency_symbol,
                    'deposit' => $walletTransaction->id
                ]),
                'updated_at' => $date,
                'created_at' => $date,
            ];
        }

        $notifications[] = [
            'user_id' => $walletTransaction->user_id,
            'message' => __('Your withdrawal request of :currency :amount has been completed by paypal. The amount added to your balance.', [
                'currency' => $walletTransaction->currency_symbol,
                'amount' => $walletTransaction->amount,
                'address' => $walletTransaction->address,
            ]),
            'link' => route('wallets.withdrawals.show', [
                'wallet' => $walletTransaction->currency_symbol,
                'withdrawal' => $walletTransaction->id
            ]),
            'updated_at' => $date,
            'created_at' => $date,
        ];

        Notification::insert($notifications);
    }

    public function paypalPayoutVoidedEvent($response) {
        $walletTransaction = WalletTransaction::where('payment_txn_id', $response['resource']['payout_batch_id'])
            ->where('payment_method', PAYMENT_METHOD_PAYPAL)
            ->where('currency_symbol', $response['resource']['payout_item']['amount']['currency'])
            ->where('status', PAYMENT_STATUS_PENDING)
            ->with('currency')
            ->first();

        if( !$walletTransaction ) {
            return false;
        }

        $walletTransaction->update([
            'payment_txn_id' => $response['resource']['transaction_id'],
            'status' => PAYMENT_STATUS_FAILED
        ]);

        $walletTransaction->wallet()->increment('balance', $walletTransaction->amount);
        $notification = [
            'user_id' => $walletTransaction->user_id,
            'message' => __('Your withdrawal request of :currency :amount to :address has been declined by paypal.', [
                'currency' => $walletTransaction->currency_symbol,
                'amount' => $walletTransaction->amount,
                'address' => $walletTransaction->address,
            ]),
            'link' => route('wallets.withdrawals.show', [
                'wallet' => $walletTransaction->currency_symbol,
                'withdrawal' => $walletTransaction->id
            ])
        ];
        Notification::create($notification);
    }
}
