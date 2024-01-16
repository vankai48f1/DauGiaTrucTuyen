<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Models\User\Auction;
use App\Services\Core\DataTableService;

class AuctionBidHistoryController extends Controller
{
    public function index(Auction $auction) {
        $data['title'] = __('Auction Bid History');
        $data['auction'] = $auction;

        if( $auction->status == AUCTION_STATUS_COMPLETED && auth()->check() ) {
            $data['winner'] = $auction->getWinner()
                ->where('user_id', auth()->id())
                ->first();
        }

        $queryBuilder = $auction->bids()
            ->when($auction->auction_type != AUCTION_TYPE_HIGHEST_BIDDER, function($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('user.profile')
            ->orderByDesc('created_at');
        $data['dataTable'] = app(DataTableService::class)
            ->withoutDateFilter()
            ->create($queryBuilder);

        return view('auction.bid_history', $data);
    }
}
