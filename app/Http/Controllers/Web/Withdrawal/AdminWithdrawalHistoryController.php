<?php

namespace App\Http\Controllers\Web\Withdrawal;

use App\Http\Controllers\Controller;
use App\Mail\Withdrawal\WithdrawalComplete;
use App\Models\Core\User;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Services\Core\DataTableService;
use App\Services\Logger\Logger;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminWithdrawalHistoryController extends Controller
{

    public function index(): View
    {
        $searchFields = [
            ['id', __('Reference ID')],
            ['address', __('Address')],
            ['symbol', __('Wallet')],
            ['email', __('Email'), 'users'],
            ['bank_name', __('Bank'), 'bankAccount'],
        ];

        $orderFields = [
            ['created_at', __('Date')],
            ['symbol', __('Wallet')]
        ];

        $filtersFields = [
            ['payment_method', __('Payment Method'), payment_methods()]
        ];

        $queryBuilder = WalletTransaction::with('user', 'bankAccount')
            ->where('txn_type', TRANSACTION_TYPE_WITHDRAWAL)
            ->orderBy('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setFilterFields($filtersFields)
            ->setOrderFields($orderFields)
            ->create($queryBuilder);

        $data['title'] = __('Review Withdrawals');

        return view('withdrawals.admin.history.index', $data);
    }

    public function show(WalletTransaction $withdrawal): View
    {
        $data['withdrawal'] = $withdrawal;
        $data['title'] = __("Withdrawal Details");
        return view('withdrawals.admin.show', $data);
    }

    public function destroy(WalletTransaction $withdrawal): RedirectResponse
    {
        DB::beginTransaction();
        try {
            //Change withdrawal status to FAILED
            if (!$withdrawal->update(['status' => PAYMENT_STATUS_CANCELED])) {
                throw new Exception(__("Failed to change status as canceled"));
            }

            //Increase wallet balance
            if (!$withdrawal->wallet()->increment('balance', $withdrawal->amount)) {
                throw new Exception(__("Failed to update wallet."));
            }
        } catch (Exception $exception) {
            DB::rollBack();
            Logger::error($exception, "[FAILED][WithdrawalService][cancel]");
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __("Failed to cancel withdrawal."));
        }

        DB::commit();

        return redirect()
            ->route('admin.review.withdrawals.index', $withdrawal->currency_symbol)
            ->with(RESPONSE_TYPE_SUCCESS, __("Successfully withdrawal cancellation process completed."));
    }

    public function update(WalletTransaction $withdrawal): RedirectResponse
    {
        $amountToBeSend = ($withdrawal->amount - $withdrawal->system_fee);

        $superAdmin = User::where('is_super_admin', ACTIVE)->first();
        $systemWallet = Wallet::where('currency_symbol', $withdrawal->currency_symbol)
            ->where('user_id', $superAdmin->id)
            ->first();

        DB::beginTransaction();
        try {
            $withdrawal->status = PAYMENT_STATUS_COMPLETED;
            //Check if the withdrawal is internal
            if ($withdrawal->payment_method === PAYMENT_METHOD_BANK) {
                $withdrawal->payment_txn_id = sprintf('transfer-%s', Str::uuid()->toString());
            } elseif (!is_null($systemWallet)) {
                $systemWallet->increment('balance', $amountToBeSend);
                $withdrawal->payment_txn_id = sprintf('transfer-%s', Str::uuid()->toString());
            }

            $withdrawal->update();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Logger::error($exception, "[FAILED][WithdrawalService][withdraw]");
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Withdrawal approval process has been failed.'));
        }

        if ($withdrawal->payment_method === PAYMENT_METHOD_BANK) {
            Mail::to($withdrawal->user->email)->send(new WithdrawalComplete($withdrawal));
        }
        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_SUCCESS, __('Withdrawal has been approved successfully.'));
    }
}
