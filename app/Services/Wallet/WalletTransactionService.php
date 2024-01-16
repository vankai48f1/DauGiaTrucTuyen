<?php


namespace App\Services\Wallet;


use App\Models\User\Wallet;
use App\Models\User\WalletTransaction;
use App\Services\Core\DataTableService;

class WalletTransactionService
{
    public function walletTransaction(Wallet $wallet, $txnType = null)
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
            'id', 'ref_id', 'payment_method', 'currency_symbol', 'amount', 'payment_txn_id', 'system_fee', 'address', 'status', 'created_at'
        ];

        $queryBuilder = $wallet->walletTransactions()->select($select)
            ->when($txnType === TRANSACTION_TYPE_DEPOSIT, function ($query) {
                if (\auth()->user()->is_super_admin){
                    $query->whereIn('txn_type', [TRANSACTION_TYPE_DEPOSIT, TRANSACTION_TYPE_SYSTEM_FEE]);
                }
                else {
                    $query->where('txn_type', TRANSACTION_TYPE_DEPOSIT);
                }
            })
            ->when($txnType === TRANSACTION_TYPE_WITHDRAWAL, function ($query) {
                if (\auth()->user()->is_super_admin){
                    $query->whereIn('txn_type', [TRANSACTION_TYPE_WITHDRAWAL, TRANSACTION_TYPE_SYSTEM_FEE]);
                }
                else {
                    $query->where('txn_type', TRANSACTION_TYPE_WITHDRAWAL);
                }
            })
            ->when(\auth()->user()->is_super_admin == INACTIVE, function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('created_at', 'desc');

        return app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filterFields)
            ->create($queryBuilder);
    }
}
