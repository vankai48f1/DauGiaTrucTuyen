<?php

namespace App\Http\Controllers\Web\Deposit;

use App\Http\Controllers\Controller;
use App\Models\User\WalletTransaction;
use App\Services\Core\DataTableService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDepositHistoryController extends Controller
{
    public function index(): View
    {
        $data['title'] = __('Deposit History');

        $data['userId'] = Auth::id();

        $searchFields = [
            ['id', __('Reference ID')],
            ['email', __('Email'), 'user'],
            ['symbol', __('Wallet')],
            ['amount', __('Amount')],
        ];

        $orderFields = [
            ['symbol', __('Wallet')],
            ['amount', __('Amount')],
            ['created_at', __('Date')],
        ];

        $filterFields = [
            ['status', __("Status"), payment_status()],
            ['payment_method', __("Payment Method"), payment_methods()]
        ];

        $downloadableHeadings = [
            ['created_at', __("Date")],
            ['id', __("Reference ID")],
            ['email', __("Email"), 'user'],
            ['address', __("Address")],
            ['bank_name', __("Bank"), 'bankAccount'],
            ['symbol', __("Wallet")],
            ['amount', __("Amount")],
            ['system_fee', __("Fee")],
            ['status', __("Status")],
        ];

        $queryBuilder = WalletTransaction::with("user")
            ->where('txn_type', TRANSACTION_TYPE_DEPOSIT)
            ->orderBy('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filterFields)
            ->downloadable($downloadableHeadings)
            ->create($queryBuilder);

        return view('deposits.admin.history.index', $data);
    }

    public function show(WalletTransaction $deposit): View
    {
        $data['deposit'] = $deposit;
        $data['title'] = __("Deposit Details");
        return view('deposits.admin.history.show', $data);
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
            if ($deposit->update()) {
                $deposit->wallet->increment('balance', $deposit->amount);
            }

            if ($deposit->bankAccount->is_verified == VERIFICATION_STATUS_UNVERIFIED) {
                $deposit->bankAccount()->update(['is_verified' => VERIFICATION_STATUS_APPROVED]);
            }

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __("Failed to approve the deposit."));
        }
        DB::commit();

        return redirect()
            ->route(replace_current_route_action('show'), $deposit->id)
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
            return redirect()
                ->route(replace_current_route_action('show'), $deposit->id)
                ->with(RESPONSE_TYPE_SUCCESS, __("The deposit has been canceled successfully."));
        }

        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_ERROR, __("Failed to cancel the deposit."));
    }
}
