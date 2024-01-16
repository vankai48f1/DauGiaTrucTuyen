<?php

namespace App\Http\Controllers\Web\Withdrawal;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Services\Core\DataTableService;

class AdminUserWithdrawalController extends Controller
{
    public function __invoke(User $user, Wallet $wallet)
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

        $queryBuilder = WalletTransaction::with('bankAccount')
            ->where('txn_type', TRANSACTION_TYPE_WITHDRAWAL)
            ->where('user_id', $user->id)
            ->where('wallet_id', $wallet->id)
            ->orderBy('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setFilterFields($filtersFields)
            ->setOrderFields($orderFields)
            ->create($queryBuilder);

        $data['title'] = __('Withdrawals History: :user', ['user' => $user->profile->full_name]);

        return view('user_transaction_history.withdrawals', $data);
    }
}
