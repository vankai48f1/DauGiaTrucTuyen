<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Models\Core\Notification;
use App\Models\User\Auction;
use App\Models\User\Bid;
use App\Services\Logger\Logger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerShippingController extends Controller
{
    public function create(Auction $auction)
    {
        $data['auction'] = $auction;

        if(
            $auction->status != AUCTION_STATUS_COMPLETED ||
            is_null($auction->address_id) ||
            $auction->seller_id != optional(auth()->user()->seller)->id
        ) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('Access Denied!'));
        }

        $data['title'] = __('Shipping Description');

        return view('auction.seller.shipping_description', $data);
    }

    public function store(Request $request, Auction $auction)
    {
        $request->validate([
            'delivery_date' => 'required|date|after_or_equal:today',
        ]);

        if (
            $auction->status != AUCTION_STATUS_COMPLETED ||
            $auction->seller_id != auth()->user()->seller->id
        ) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('Invalid Request!'));
        }

        $attributes = [
            'delivery_date' => $request->delivery_date,
            'product_claim_status' => AUCTION_PRODUCT_CLAIM_STATUS_ON_SHIPPING,
        ];

        try{
            DB::beginTransaction();

            if( !$auction->update($attributes) ) {
                throw new \Exception(__('Failed to update auction!'));
            }

            $date = now();
            $route = route('shipping-description.create', $auction->ref_id);
            $notificationAttributes = [
                'user_id' => $auction->getWinner->user_id,
                'message' => __('Your product of :auction auction is on shipping', ['auction' => '<strong>' . $auction->title . '</strong>']),
                'link' => $route,
                'updated_at' => $date,
                'created_at' => $date,
            ];

            Notification::create($notificationAttributes);

            DB::commit();

            return redirect()
                ->route('seller.shipping-description.create', $auction->ref_id)
                ->with(RESPONSE_TYPE_SUCCESS, __('The delivery date has been placed successfully.'));
        }
        catch (\Exception $exception) {
            DB::rollback();
            Logger::error($exception, '[FAILED][SellerShippingController][store]');
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to submit the request'));
    }
}
