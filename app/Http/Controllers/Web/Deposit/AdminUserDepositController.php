<?php

namespace App\Http\Controllers\Web\Deposit;

use App\Http\Controllers\Controller;
use App\Models\Core\User;
use App\Models\User\Wallet;
use App\Services\Core\DataTableService;
use Illuminate\View\View;

class AdminUserDepositController extends Controller
{
    public function __invoke(User $user, Wallet $wallet): View
    {
        $searchFields = [
            ['payment_txn_id', __('Transaction ID')],
            ['address', __('Email')],
            ['amount', __('Amount')],
        ];
        $orderFields = [
            ['txn_type', __('Transaction Type')],
            ['payment_method', __('Payment Method')],
            ['amount', __('Amount')],
            ['address', __('Email')],
            ['network_fee', __('Network Fee')],
            ['system_fee', __('System Fee')],
        ];

        $filterFields = [
            ['wallet_transactions.txn_type', __('Transaction Type'), payment_methods()],
            ['wallet_transactions.status', __('Status'), payment_status()],
        ];
        $select = [
            'id', 'ref_id', 'user_id', 'payment_method', 'currency_symbol', 'amount', 'payment_txn_id', 'system_fee', 'address', 'status', 'created_at'
        ];

        $queryBuilder = $wallet->walletTransactions()->select($select)
            ->where('txn_type', TRANSACTION_TYPE_DEPOSIT)
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filterFields)
            ->create($queryBuilder);

        $data['title'] = __('Deposit History: :user', ['user' => $user->profile->full_name]);

        return view('user_transaction_history.deposits', $data);
    }
}
