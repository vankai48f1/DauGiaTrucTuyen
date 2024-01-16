<?php


namespace App\Services\Transaction;


use App\Models\Core\Notification;
use App\Models\Core\User;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Services\Logger\Logger;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    public function completePaypalOrder($response): void
    {
        $walletTransaction = WalletTransaction::where('payment_txn_id', $response['payment_txn_id'])
            ->where('status', PAYMENT_STATUS_PENDING)
            ->where('payment_method', PAYMENT_METHOD_PAYPAL)
            ->with('currency')
            ->first();

        if (!empty($walletTransaction)) {
            try {
                DB::beginTransaction();
                $netAmount = $response['net_amount'];

                $systemFee = calculate_deposit_system_fee(
                    $netAmount,
                    $walletTransaction->wallet->currency->deposit_fee,
                    $walletTransaction->wallet->currency->deposit_fee_type
                );

                $networkFee = $response['network_fee'];
                $walletTransaction->update([
                    'status' => PAYMENT_STATUS_COMPLETED,
                    'network_fee' => $networkFee,
                    'system_fee' => $systemFee
                ]);

                $netAmount = ($netAmount - $systemFee);

                $walletTransaction->wallet()->increment('balance', $netAmount);

                $superAdmin = User::where('is_super_admin', ACTIVE)->first();

                if (!empty($superAdmin) && $walletTransaction->system_fee > 0 ) {
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

                    $notification = [
                        'user_id' => $systemWallet->user_id,
                        'message' => __(':amount :currency  has been credited to your wallet as profit (user deposit fee)',
                            [
                                'currency' => $walletTransaction->currency_symbol,
                                'amount' => $walletTransaction->system_fee,
                            ]),
                        'link' => route('wallets.deposits.show', [
                            'wallet' => $walletTransaction->currency_symbol,
                            'deposit' => $walletTransaction->id
                        ])
                    ];
                    Notification::create($notification);
                }
                DB::commit();
            } catch (Exception $exception) {
                Logger::error($exception, '[FAILED][PaymentService][completePaypalOrder]');

                DB::rollBack();
            }
        }
    }
}
