<?php

namespace App\Services\User;

use App\Models\Core\Notification;
use App\Models\User\Auction;
use App\Models\User\Bid;
use App\Models\User\Wallet;
use App\Services\Logger\Logger;
use Exception;
use Illuminate\Support\Facades\DB;

class WinnerSelectionService
{

    public function winnerSelector(Auction $auction)
    {
        if ($auction->status != AUCTION_STATUS_RUNNING) {
            return false;
        }

        if ($auction->auction_type == AUCTION_TYPE_HIGHEST_BIDDER) {
            $this->highestBidWinner($auction);
        }

        if ($auction->auction_type == AUCTION_TYPE_BLIND_BIDDER) {
            $this->blindBidWinner($auction);
        }

        if ($auction->auction_type == AUCTION_TYPE_VICKREY_BIDDER) {
            $this->vickreyBidWinner($auction);
        }

        if ($auction->auction_type == AUCTION_TYPE_UNIQUE_BIDDER) {
            $this->uniqueBidWinner($auction);
        }
    }

    public function highestBidWinner($auction): bool
    {
        $winnerBid = $auction->bids()->orderBy('amount', 'desc')->orderBy('id')->first();

        if (empty($winnerBid)) {
            return false;
        }

        DB::beginTransaction();
        if( $this->_makeWinner($auction, $winnerBid) ) {
            DB::commit();

            return true;
        }

        DB::rollBack();

        return false;
    }

    private function _makeWinner(Auction $auction, Bid $bid): bool
    {
        try {
            $updateAsWinner = $bid->update(['is_winner' => AUCTION_WINNER_STATUS_WIN]);
            $completeAuction = $auction->update(['status' => AUCTION_STATUS_COMPLETED]);
            if (!$updateAsWinner || !$completeAuction) {
                throw new Exception('Failed to complete the auction.');
            }

            $route = route('shipping-description.create', $auction->ref_id);
            $notificationAttributes = [
                'user_id' => $bid->user_id,
                'message' => __('You just won the :auction, please submit your address', ['auction' => '<strong>' . $auction->title . '</strong>']),
                'link' => $route,
            ];

            Notification::create($notificationAttributes);

            return true;

        } catch (Exception $exception) {
            Logger::error($exception, '[FAILED][WinnerSelectionService][_makeWinner]');
        }

        return false;
    }

    public function blindBidWinner($auction): bool
    {
        $winnerBid = $auction->bids()->orderBy('amount', 'desc')->orderBy('id')->first();

        if (empty($winnerBid)) {
            return false;
        }
        DB::beginTransaction();

        if ($this->_makeWinner($auction, $winnerBid) && $this->_reverseBids($auction, $winnerBid)) {
            DB::commit();
            return true;
        }

        DB::rollBack();

        return false;
    }

    private function _reverseBids(Auction $auction, Bid $winnerBid): bool
    {
        $walletRoute = route('wallets.index');
        $reverseBids = $auction->bids()->getHighestBids();
        $walletAttributes = [];
        $notificationAttributes = [];

        foreach ($reverseBids as $bid) {
            $refundableAmount = $bid->amount;
            if ($bid->user_id === $winnerBid->user_id) {
                continue;
            }
            if ($refundableAmount) {
                $walletAttributes[] = [
                    'conditions' => ['user_id' => $bid->user_id, 'currency_symbol' => $auction->currency_symbol],
                    'fields' => [
                        'balance' => ['increment', $refundableAmount],
                        'updated_at' => now(),
                    ]
                ];

                $notificationAttributes[] = [
                    'user_id' => $bid->user_id,
                    'message' => __('Your :currency :amount has been restored to your wallet on bidding to :auction', ['auction' => '<strong>' . $auction->title . '</strong>', 'currency' => '<strong>' . $auction->currency_symbol . '</strong>', 'amount' => '<strong>' . $bid->amount . '</strong>']),
                    'link' => $walletRoute,
                    'updated_at' => now(),
                    'created_at' => now(),
                ];
            }
        }

        try {
            if (Wallet::bulkUpdate($walletAttributes) < count($walletAttributes)) {
                throw new Exception('Failed to update wallet while reversing balance.');
            }

            Notification::insert($notificationAttributes);

            return true;
        } catch (Exception $exception) {
            Logger::error($exception, '[FAILED][WinnerSelectionService][_reverseBids]');
        }

        return false;
    }

    public function vickreyBidWinner($auction)
    {
        $winnerBid = $auction->bids()->orderBy('amount', 'desc')->orderBy('id', 'asc')->first();
        if (empty($winnerBid)) {
            return false;
        }
        $winnerPayableBid = $auction->bids()
            ->orderBy('amount', 'desc')
            ->orderBy('id', 'asc')
            ->skip(1)
            ->first();

        $adjustedBidAmount = $auction->bids()->count() > 1 ? ($winnerBid->amount - $winnerPayableBid->amount) : 0;

        DB::beginTransaction();

        if ($this->_makeWinner($auction, $winnerBid) && $this->_reverseBids($auction, $winnerBid)) {
            if($adjustedBidAmount) {
                $winnerWaller = Wallet::where('user_id', $winnerBid->user_id)
                    ->where('currency_symbol', $auction->currency_symbol)
                    ->first();

                if($winnerWaller) {
                    $winnerWaller->increment('balance', $adjustedBidAmount);
                } else {
                    DB::rollBack();
                    return false;
                }
            }

            DB::commit();

            return true;
        }

        DB::rollBack();
    }

    public function uniqueBidWinner($auction)
    {
        $winnerBid = $auction->bids()->findUniqueBidWinner();

        if (empty($winnerBid)) {
            return false;
        }

        $winnerHighestBid = $auction->bids()->where('user_id', $winnerBid->user_id)->orderByDesc('amount')->first();
        $adjustedBidAmount = 0;

        if( $winnerBid->id != $winnerHighestBid->id ) {
            $adjustedBidAmount = ($winnerHighestBid->amount - $winnerBid->amount);
        }

        DB::beginTransaction();

        if ($this->_makeWinner($auction, $winnerBid) && $this->_reverseBids($auction, $winnerBid)) {
            if($adjustedBidAmount) {
                $winnerWaller = Wallet::where('user_id', $winnerBid->user_id)
                    ->where('currency_symbol', $auction->currency_symbol)
                    ->first();

                if($winnerWaller) {
                    $winnerWaller->increment('balance', $adjustedBidAmount);
                } else {
                    DB::rollBack();
                    return false;
                }
            }

            DB::commit();

            return true;
        }

        DB::rollBack();
    }
}
