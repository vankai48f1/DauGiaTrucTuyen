<?php

namespace App\Http\Controllers\Web\Deposit;

use App\Http\Controllers\Controller;
use App\Models\Core\Notification;
use App\Models\Core\User;
use App\Models\User\WalletTransaction;
use App\Services\Core\DataTableService;
use App\Services\Logger\Logger;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminBankDepositReviewController extends Controller
{
    public function index(): View
    {
        $data['title'] = __('Review Bank Deposits');

        $data['userId'] = Auth::id();
        $searchFields = [
            ['id', __('Reference ID')],
            ['email', __('Email'), 'user'],
            ['bank_name', __('Bank'), 'bankAccount'],
            ['symbol', __('Wallet')],
            ['amount', __('Amount')],
        ];

        $orderFields = [
            ['symbol', __('Wallet')],
            ['amount', __('Amount')],
            ['created_at', __('Date')],
        ];

        $queryBuilder = WalletTransaction::with("user")
            ->where('status', PAYMENT_STATUS_REVIEWING)
            ->where('payment_method', PAYMENT_METHOD_BANK)
            ->orderBy('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->create($queryBuilder);

        return view('deposits.admin.review_bank_deposits.index', $data);
    }

    public function show(WalletTransaction $deposit): View
    {
        abort_if($deposit->payment_method != PAYMENT_METHOD_BANK || $deposit->status != PAYMENT_STATUS_REVIEWING, 404);
        $data['deposit'] = $deposit;
        $data['title'] = __("Deposit Details");
        return view('deposits.admin.review_bank_deposits.show', $data);
    }

    public function update(WalletTransaction $deposit): RedirectResponse
    {
        if ($deposit->status != PAYMENT_STATUS_REVIEWING) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __("Cannot approve this deposit."));
        }

        $deposit->status = PAYMENT_STATUS_COMPLETED;

        DB::beginTransaction();
        try {
            if ( !$deposit->update() ) {
                throw new Exception(__('Failed to update the deposit status.'));
            }

            $netAmount = ($deposit->amount - $deposit->system_fee);
            if( !$deposit->wallet->increment('balance', $netAmount) ) {
                throw new Exception(__('Failed to update the user balance.'));
            }

            $superAdmin = User::where('is_super_admin', ACTIVE)
                ->first();

            $notifications = [];

            if( $deposit->system_fee > 0 ) {
                $isSuperAdminBalanceUpdated = $superAdmin
                    ->wallets()
                    ->where('currency_symbol', $deposit->currency_symbol)
                    ->increment('balance', $deposit->system_fee);

                if( !$isSuperAdminBalanceUpdated ) {
                    throw new Exception(__('Failed to update the admin balance.'));
                }

                $notifications[] = [
                    'user_id' => $superAdmin->id,
                    'message' => __(':amount :currency  has been credited to your wallet as profit (user deposit fee)', [
                        'currency' => $deposit->currency_symbol,
                        'amount' => $deposit->system_fee,
                    ]),
                ];
            }

            if ($deposit->bankAccount->is_verified == VERIFICATION_STATUS_UNVERIFIED) {
                if( !$deposit->bankAccount()->update(['is_verified' => VERIFICATION_STATUS_APPROVED]) )
                {
                    throw new Exception(__('Failed to update bank verification status.'));
                }
            }

            $notifications[] = [
                'user_id' => $deposit->user_id,
                'message' => __('Your deposit request of :currency :amount has been approved by system. The amount has been added to your balance.', [
                    'currency' => $deposit->currency_symbol,
                    'amount' => $deposit->amount,
                ]),
                'link' => route('wallets.deposits.show', [
                    'wallet' => $deposit->currency_symbol,
                    'deposit' => $deposit->id
                ])
            ];

            Notification::insert($notifications);

        } catch (Exception $exception) {
            DB::rollBack();
            Logger::error($exception, '[FAILED][AdminBankDepositReviewController][update]');
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __("Failed to approve the deposit."));
        }

        DB::commit();

        return redirect()
            ->route(replace_current_route_action('index'))
            ->with(RESPONSE_TYPE_SUCCESS, __("The deposit has been approved successfully."));
    }

    public function destroy(WalletTransaction $deposit): RedirectResponse
    {
        if ($deposit->status != PAYMENT_STATUS_REVIEWING) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __("Cannot cancel the deposit."));
        }

        if ($deposit->update(['status' => PAYMENT_STATUS_CANCELED])) {
            $notification = [
                'user_id' => auth()->id(),
                'message' => __('Your deposit request of :currency :amount has been declined by system.',
                    [
                        'currency' => $deposit->currency_symbol,
                        'amount' => $deposit->amount,
                    ]),
                'link' => route('wallets.deposits.show', [
                    'wallet' => $deposit->currency_symbol,
                    'deposit' => $deposit->id
                ])
            ];
            Notification::create($notification);
            return redirect()
                ->route(replace_current_route_action('index'))
                ->with(RESPONSE_TYPE_SUCCESS, __("The deposit has been canceled successfully."));
        }

        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_ERROR, __("Failed to cancel the deposit."));
    }
}
