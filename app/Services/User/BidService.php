<?php

namespace App\Services\User;

use App\Models\Core\Notification;
use App\Models\Core\User;
use App\Models\User\Bid;
use App\Models\User\Wallet;
use App\Services\Logger\Logger;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BidService
{

    public function highestBid($auction, $parameters, $onBiddingUserWallet)
    {

        $highestBidderBiddingFee = settings('bidding_fee_on_highest_bidder_auction', 0);

        $totalBidAmount = ($parameters['amount'] + $highestBidderBiddingFee);

        $highestBid = $auction->bids()->orderByDesc('amount')->first();

        $bidCount = $auction->bids()->count();

        if ($bidCount > 0) {

            if ( ($highestBid->amount + $auction->bid_increment_dif) > $parameters['amount'] ) {
                return [
                    RESPONSE_STATUS_KEY => RESPONSE_TYPE_ERROR,
                    RESPONSE_MESSAGE_KEY => __('You can not bid less than minimum bid amount'),
                ];
            }

        } else {
            if ( $auction->bid_initial_price > $parameters['amount'] ) {
                return [
                    RESPONSE_STATUS_KEY => RESPONSE_TYPE_ERROR,
                    RESPONSE_MESSAGE_KEY => __('You can not bid less than base price'),
                ];
            }
        }

        $superAdmin = User::where('is_super_admin', ACTIVE )->first();
        $parameters['system_fee'] = $highestBidderBiddingFee;

        $walletAttributes = [
            [
                'conditions' => ['user_id' => $onBiddingUserWallet->user_id, 'currency_symbol' => $auction->currency_symbol],
                'fields' => [
                    'on_order' => ['increment', $parameters['amount']],
                    'balance' => ['decrement', $totalBidAmount],
                ]
            ],
            [
                'conditions' => ['user_id' => $superAdmin->id, 'currency_symbol' => $auction->currency_symbol],
                'fields' => [
                    'balance' => ['increment', $highestBidderBiddingFee],
                    'updated_at' => now()
                ]
            ],
        ];

        try {

            DB::beginTransaction();

            if (Wallet::bulkUpdate($walletAttributes) < count($walletAttributes)) {
                throw new Exception('Failed to bid please try again later');
            }

            if ($bidCount > 0) {
                if (!$this->bidReversalTransaction($auction, $highestBid)) {
                    throw new Exception('Failed to bid please try again later');
                }
            }

            Bid::create($parameters);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();

            Logger::error($exception, '[FAILED][BidService][highestBid]');
            return [
                RESPONSE_STATUS_KEY => RESPONSE_TYPE_ERROR,
                RESPONSE_MESSAGE_KEY => __('Failed to bid please try again later'),
            ];
        }

        return [
            RESPONSE_STATUS_KEY => RESPONSE_TYPE_SUCCESS,
            RESPONSE_MESSAGE_KEY => __('Your bid has been placed successfully'),
        ];

    }

    public function blindBid($auction, $parameters)
    {
        $biddingFee = settings('bidding_fee_on_blind_bidder_auction',0);

        return $this->adjustBidAmount($auction, $parameters, $biddingFee);
    }

    public function vickreyBid($auction, $parameters)
    {
        $biddingFee = settings('bidding_fee_on_vickrey_bidder_auction',0);

        return $this->adjustBidAmount($auction, $parameters, $biddingFee);

    }

    public function uniqueBid($auction, $parameters)
    {
        $biddingFee = settings('bidding_fee_on_unique_bidder_auction',0);

        return $this->adjustBidAmount($auction, $parameters, $biddingFee);
    }

    public function bidReversalTransaction($auction, $highestBid)
    {

        $existedHighestBidderWallet = Wallet::where('user_id', $highestBid->user_id)
            ->where('currency_symbol', $auction->currency_symbol)
            ->first();

        $existedWalletAttributes = [
            'on_order' => DB::raw('on_order - ' . $highestBid->amount),
            'balance' => DB::raw('balance + ' . $highestBid->amount),
        ];

        if (!$existedHighestBidderWallet->update($existedWalletAttributes)) {
            return false;
        }

        $route = route('auction.show', $auction->ref_id);
        $notificationAttributes = [
            'user_id' => $highestBid->user_id,
            'message' => __('Your :currency :amount has been restored to your balance from bidding on :auction', ['currency' => '<strong>' . $existedHighestBidderWallet->currency->symbol . '</strong>', 'amount' => '<strong>' . $highestBid->amount . '</strong>', 'auction' => '<strong>' . $auction->title . '</strong>']),
            'link' => $route,
        ];

        Notification::create($notificationAttributes);

        return true;
    }

    public function adjustBidAmount($auction, $parameters, $biddingFee)
    {
        if ( $auction->bid_initial_price > $parameters['amount'] ) {
            return [
                RESPONSE_STATUS_KEY => RESPONSE_TYPE_ERROR,
                RESPONSE_MESSAGE_KEY => __('You can not bid less than base price'),
            ];
        }

        $actualBidAmount = ($parameters['amount'] + $biddingFee);
        $adjustedAmount = $parameters['amount'];
        $route = route('auction.show', $auction->ref_id);
        $superAdmin = User::where('is_super_admin', ACTIVE )->first();
        $maxBidAmount = $auction->bids()->where('user_id', auth()->id())->max('amount');

        try {

            DB::beginTransaction();

            if (!empty($maxBidAmount)){
                if ( $maxBidAmount < $parameters['amount'] )
                {
                    $adjustedAmount = ($parameters['amount'] - $maxBidAmount);
                    $actualBidAmount = ($adjustedAmount + $biddingFee);

                } else {

                    $adjustedAmount = 0;
                    $actualBidAmount = $biddingFee;

                }
            }

            $walletAttributes = [
                [
                    'conditions' => ['user_id' => auth()->id(), 'currency_symbol' => $auction->currency_symbol],
                    'fields' => [
                        'on_order' => ['increment', $adjustedAmount],
                        'balance' => ['decrement', $actualBidAmount],
                    ]
                ],
                [
                    'conditions' => ['user_id' => $superAdmin->id, 'currency_symbol' => $auction->currency_symbol],
                    'fields' => [
                        'balance' => ['increment', $biddingFee],
                        'updated_at' => now(),
                    ]
                ],
            ];

            if (Wallet::bulkUpdate($walletAttributes) < count($walletAttributes)) {
                throw new Exception('Failed to bid please try again later');
            }

            $notificationAttributes = [
                'user_id' => auth()->id(),
                'message' => __('Your :currency :amount has been adjusted with your last bid on :auction', ['currency' => '<strong>' . $auction->currency->symbol . '</strong>', 'amount' => '<strong>' . $adjustedAmount . '</strong>', 'auction' => '<strong>' . $auction->title . '</strong>']),
                'link' => $route,
            ];

            Notification::create($notificationAttributes);

            Bid::create($parameters);

            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();

            Logger::error($exception, '[FAILED][BidService][adjustBidAmount]');
            return [
                RESPONSE_STATUS_KEY => RESPONSE_TYPE_ERROR,
                RESPONSE_MESSAGE_KEY => __('Failed to bid please try again later'),
            ];
        }

        return [
            RESPONSE_STATUS_KEY => RESPONSE_TYPE_SUCCESS,
            RESPONSE_MESSAGE_KEY => __('Your bid has been placed successfully'),
        ];
    }

    public function place($auction, $parameters, $onBiddingUserWallet = null)
    {
        $bidFunc = Str::camel(auction_type($auction->auction_type));

        if ($bidFunc === 'highestBid') {

            return $this->{$bidFunc}($auction, $parameters, $onBiddingUserWallet);
        }

        return $this->{$bidFunc}($auction, $parameters);

    }

}
