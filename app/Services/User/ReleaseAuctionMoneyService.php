<?php

namespace App\Services\User;

use App\Models\Core\Notification;
use App\Models\Core\User;
use App\Models\User\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;

class ReleaseAuctionMoneyService
{

    public function releaseAuctionMoney($auction)
    {
        $date = now();
        $superAdmin = User::where('is_super_admin', ACTIVE)->first();
        $isWinner = $auction->getWinner;

        $parameters['product_claim_status'] = AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED;

        try {

            DB::beginTransaction();

            if (!$auction->update($parameters)) {
                throw new Exception('Failed to update auction status in money release function.');
            }

            $auction->load('bids');

            if (
                $auction->auction_type == AUCTION_TYPE_VICKREY_BIDDER &&
                $auction->bids->count() > 1
            ) {
                $winnerPayableAmount = $auction->bids()
                    ->orderBy('amount', 'desc')
                    ->orderBy('id', 'asc')
                    ->skip(1)
                    ->first();
                $winnerAmount = $winnerPayableAmount->amount;

            } else {
                $winnerAmount = $isWinner->amount;
            }

            $auctionFeeType = settings('auction_fee_type', 0);
            $auctionFeeInPercent = settings('auction_fee_in_percent', 0);
            $amountOfAuctionFeeInPercent = (($winnerAmount * $auctionFeeInPercent) /100);
            $auctionFeeInFixedAmount = settings('auction_fee_in_fixed_amount', 0);

            if ($auctionFeeType == AUCTION_FEE_IN_PERCENT) {
                $totalFee = $amountOfAuctionFeeInPercent;
            } elseif ($auctionFeeType == AUCTION_FEE_IN_FIXED_AMOUNT) {
                $totalFee = $auctionFeeInFixedAmount;
            } else {
                $totalFee = ($amountOfAuctionFeeInPercent + $auctionFeeInFixedAmount);
            }

            $sellerAmount = ($winnerAmount - $totalFee);

            $walletAttributes = [
                [
                    'conditions' => ['user_id' => $auction->seller->user_id, 'currency_symbol' => $auction->currency_symbol],
                    'fields' => [
                        'balance' => ['increment', $sellerAmount],
                        'updated_at' => $date
                    ],
                ],
                [
                    'conditions' => ['user_id' => $superAdmin->id, 'currency_symbol' => $auction->currency_symbol],
                    'fields' => [
                        'balance' => ['increment', $totalFee],
                        'updated_at' => $date
                    ],
                ],
                [
                    'conditions' => ['user_id' => $isWinner->user_id, 'currency_symbol' => $auction->currency_symbol],
                    'fields' => [
                        'on_order' => ['decrement', $isWinner->amount],
                        'updated_at' => $date
                    ],
                ],
            ];

            $walletUpdateCount = Wallet::bulkUpdate($walletAttributes);

            if ($walletUpdateCount != count($walletAttributes)) {
                throw new Exception('Failed to bid please try again later');
            }

            $route = route('wallets.index');
            $notificationAttributes = [
                [
                    'user_id' => $auction->seller->user_id,
                    'message' => __(':currency :amount has been added to your account as you have completed your :auction..', ['currency' => '<strong>' . $auction->currency->symbol . '</strong>', 'amount' => '<strong>' . $sellerAmount . '</strong>', 'auction' => '<strong>' . $auction->title . '</strong>']),
                    'link' => $route,
                    'updated_at' => $date,
                    'created_at' => $date,
                ],
                [
                    'user_id' => $auction->seller->user_id,
                    'message' => __('you have been charged :currency :amount as you sold your product by :auction..', ['currency' => '<strong>' . $auction->currency->symbol . '</strong>', 'amount' => '<strong>' . $totalFee . '</strong>', 'auction' => '<strong>' . $auction->title . '</strong>']),
                    'link' => $route,
                    'updated_at' => $date,
                    'created_at' => $date,
                ],
                [
                    'user_id' => $superAdmin->id,
                    'message' => __(':currency :amount has been credited to your wallet as :auction completion fee.', ['currency' => '<strong>' . $auction->currency->symbol . '</strong>', 'amount' => '<strong>' . $totalFee . '</strong>', 'auction' => '<strong>' . $auction->title . '</strong>',]),
                    'link' => $route,
                    'updated_at' => $date,
                    'created_at' => $date,
                ]
            ];

            Notification::insert($notificationAttributes);
            DB::commit();

        } catch (Exception $exception) {
            DB::rollBack();
            return false;
        }

        return true;
    }
}
