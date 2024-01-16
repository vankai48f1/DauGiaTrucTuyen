<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Models\User\Auction;
use App\Services\Core\DataTableService;

class AdminCompletedAuctionController extends Controller
{
    public function index()
    {
        $searchFields = [
            ['title', __('Title')],
        ];
        $orderFields = [
            ['auction_type', __('Type')],
            ['status', __('Status')],
            ['bid_initial_price', __('Starting Price')],
            ['category_id', __('Category')],
            ['currency_id', __('Currency')],
        ];

        $filters = [
            ['auctions.auction_type', __('Type'), auction_type()],
            ['auctions.product_claim_status', __('Product Claim Status'), product_claim_status()],
        ];

        $queryBuilder = Auction::query()
            ->where('status', AUCTION_STATUS_COMPLETED)
            ->with('seller', 'winnerBid.user')
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filters)
            ->create($queryBuilder);

        $data['title'] = __('Completed Auction List');

        return view('completed_auction.admin.index', $data);
    }
}
