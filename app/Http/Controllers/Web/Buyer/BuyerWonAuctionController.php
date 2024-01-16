<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Models\User\Auction;
use App\Models\User\Bid;
use App\Services\Core\DataTableService;

class BuyerWonAuctionController extends Controller
{

    public function __invoke()
    {
        $searchFields = [
            ['title', __('Title')]
        ];

        $orderFields = [
            ['auction_type', __('Type')],
            ['bid_initial_price', __('Starting Price')],
            ['category_id', __('Category')],
            ['currency_id', __('Currency')],
        ];

        $filters = [
            ['auction_type', __('Type'), auction_type()],
            ['product_claim_status', __('Product Claim Status'), product_claim_status()],
        ];

        $data['title'] = __('My Won Auctions');

        $queryBuilder = Auction::query()
            ->addSelect([
                'is_winner' => Bid::select('is_winner')->whereColumn('auction_id', 'auctions.id')
                    ->where('is_winner', ACTIVE)
                    ->where('user_id', auth()->id())
                    ->limit(1)
            ])
            ->with('seller', 'category')
            ->whereHas('bids', function ($q) {
                $q->where('user_id', auth()->id())
                    ->where('is_winner', ACTIVE);
            })
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filters)
            ->create($queryBuilder);

        return view('auction.buyer.won_auctions', $data);
    }
}
