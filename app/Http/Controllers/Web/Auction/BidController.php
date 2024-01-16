<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BidRequest;
use App\Models\User\Auction;
use App\Services\User\BidService;

class BidController extends Controller
{

    protected $service;

    public function __construct(BidService $service)
    {
        $this->service = $service;
    }

    public function store(BidRequest $request, $auctionId)
    {
        if (auth()->user()->assigned_role === USER_ROLE_ADMIN) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('Admin can not bid in any auction.'));
        }

        $isIdVerificationRequired = settings('is_id_verified');
        $isAddressVerifiedRequired = settings('is_address_verified');

        if ($isIdVerificationRequired == ACTIVE && auth()->user()->is_id_verified == INACTIVE) {
            return redirect()
                ->back()
                ->withInput()
                ->with(RESPONSE_TYPE_ERROR, __('ID verification is required to place a bid'));
        }

        if ($isAddressVerifiedRequired == ACTIVE && auth()->user()->is_address_verified == INACTIVE) {
            return redirect()
                ->back()
                ->withInput()
                ->with(RESPONSE_TYPE_ERROR, __('Address verification is required to place a bid'));
        }

        $auction = Auction::where('id', $auctionId)
            ->where('status', AUCTION_STATUS_RUNNING)
            ->with('seller')
            ->first();

        if (!$auction) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('Invalid Request!'));
        }

        if ($auction->seller->user_id == auth()->id()) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('You can not bid on your own auction'));
        }

        if ($auction->ending_date->lessThanOrEqualTo(now())) {

            if ($auction->status == AUCTION_STATUS_RUNNING) {
                $auction->update(['status' => AUCTION_STATUS_COMPLETED]);
            }
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('Bidding time has already expired for this auction'));
        }

        $onBiddingUserWallet = auth()->user()
            ->wallets()
            ->where('currency_symbol', $auction->currency_symbol)
            ->first();

        if ($onBiddingUserWallet->currency->is_active != ACTIVE) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('Sorry, The :currency currency is unavailable right now', [
                        'currency' => $onBiddingUserWallet->currency->symbol
                    ]
                ));
        }

        if ( $request->amount > $onBiddingUserWallet->balance ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(RESPONSE_TYPE_ERROR, __('You do not have sufficient balance'));
        }

        if ($auction->is_multiple_bid_allowed != ACTIVE) {
            $checkBid = auth()->user()
                ->bids()
                ->where('auction_id', $auctionId)
                ->first();

            if ($checkBid) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(RESPONSE_TYPE_ERROR, __('You can not bid again, Multiple bid is not allowed'));
            }
        }

        $parameters = $request->only('amount');
        $parameters['user_id'] = auth()->id();
        $parameters['auction_id'] = $auction->id;
        $parameters['currency_symbol'] = $auction->currency_symbol;

        $response = $this->service->place($auction, $parameters, $onBiddingUserWallet);
        if ($response[RESPONSE_STATUS_KEY]) {
            return redirect()
                ->back()
                ->with($response[RESPONSE_STATUS_KEY], $response[RESPONSE_MESSAGE_KEY]);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to place the bid.'));

    }

}
