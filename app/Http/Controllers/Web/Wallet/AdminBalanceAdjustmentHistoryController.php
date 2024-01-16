<?php

namespace App\Http\Controllers\Web\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Services\Core\DataTableService;

class AdminBalanceAdjustmentHistoryController extends Controller
{
    public function __invoke(User $user, Wallet $wallet)
    {
        $searchFields = [
            ['id', __('Reference ID')],
            ['currency_symbol', __('Wallet')],
            ['email', __('Email'), 'users'],
        ];

        $orderFields = [
            ['created_at', __('Date')],
            ['currency_symbol', __('Wallet')]
        ];

        $queryBuilder = WalletTransaction::where('user_id', $user->id)
            ->where('wallet_id', $wallet->id)
            ->orderBy('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->create($queryBuilder);

        $data['title'] = __('Adjustment History of :user', ['user' => $user->profile->full_name]);

        return view('user_transaction_history.adjust_balance', $data);
    }
}
