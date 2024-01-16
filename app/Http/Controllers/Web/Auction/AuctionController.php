<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Models\User\Auction;
use App\Models\User\Wallet;
use App\Services\Core\DataTableService;
use Illuminate\Http\Request;

class AuctionController extends Controller
{

    public function index(Request $request)
    {
        $conditions = [
            'status' => AUCTION_STATUS_RUNNING
        ];

        $category = '';

        if ($request->get('category')) {
            $category = $request->get('category');
        }

        $routeName = 'auction.home';

        $searchFields = [
            ['title', __('Auction Title')],
            ['slug', __('Category'), 'category'],
        ];
        $orderFields = [
            ['auction_type', __('Auction Type')],
            ['bid_initial_price', __('Starting Price')],
            ['category_id', __('Category')],
            ['currency_id', __('Currency')],
        ];

        $filters = [
            ['auction_type', __('Auction Type'), auction_type()],
        ];

        $queryBuilder = Auction::where($conditions)
            ->when($category, function ($query) use($category){
                $query->whereHas('category', function ($q) use($category) {
                    $q->where('slug', $category);
                });
            })
            ->with('seller', 'category')
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filters)
            ->setPaginationInfo(['itemPerPage' => 12])
            ->create($queryBuilder);

        $data['title'] = 'All Auctions';
        $data['routeName'] = $routeName;

        return view('auction.index', $data);
    }

    public function show(Auction $auction)
    {
        $data['auction'] = $auction;
        $data['currentBalance'] = Wallet::where('user_id', auth()->id())
            ->where('currency_symbol', $auction->currency_symbol)
            ->first();
        $data['title'] = __('Auction Details');

        if (auth()->check() && optional(auth()->user()->seller)->id != $auction->seller_id && auth()->user()->assigned_role != USER_ROLE_ADMIN)
        {
            $data['myLastBid'] = $auction->bids()->where('user_id', auth()->id())->orderByDesc('created_at')->first();
        }


        if( $auction->auction_type == AUCTION_TYPE_HIGHEST_BIDDER ) {
            $data['highestBid'] = $auction->bids()
                ->orderByDesc('amount')
                ->first();
        }

        if( $auction->status == AUCTION_STATUS_COMPLETED && auth()->check() ) {
            $data['winner'] = $auction->getWinner()
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('seller.auction.show', $data);
    }

}
