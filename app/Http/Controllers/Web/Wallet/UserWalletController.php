<?php

namespace App\Http\Controllers\Web\Wallet;

use App\Http\Controllers\Controller;
use App\Models\User\Bid;
use App\Models\User\Wallet;
use App\Services\Core\DataTableService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserWalletController extends Controller
{

    public function index()
    {
        (new Wallet())->checkMissingWallets();

        $searchFields = [
            ['balance', __('Balance')],
            ['on_order', __('On Order')],
        ];
        $orderFields = [
            ['balance', __('Balance')],
            ['currency_id', __('Currency')],
            ['on_order', __('On Order')],
            ['is_system', __('System')],
        ];

        $queryBuilder = wallet::query()
            ->where('user_id', Auth::user()->id)
            ->where('is_system', INACTIVE)
            ->when(auth()->user()->assigned_role == USER_ROLE_SELLER, function ($query) {
                $query->addSelect([
                    'pending_amount' => Bid::select(DB::raw('SUM(amount)'))
                        ->whereColumn('currency_symbol', 'wallets.currency_symbol')
                        ->where('is_winner', ACTIVE)
                        ->whereHas('auction', function ($query) {
                            $query->where('seller_id', auth()->user()->seller->id);
                            $query->where('status', AUCTION_STATUS_COMPLETED);
                            $query->where('product_claim_status', '!=', AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED);
                        })
                        ->limit(1)
                ]);
            })
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->withoutDateFilter()
            ->create($queryBuilder);

        $data['title'] = 'My Wallet';
        return view('user.transaction.wallet', $data);
    }
}
