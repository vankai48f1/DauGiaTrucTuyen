<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ShippingDescriptionRequest;
use App\Models\Core\Country;
use App\Models\Core\Notification;
use App\Models\User\Address;
use App\Models\User\Auction;
use App\Models\User\Bid;
use App\Services\Logger\Logger;
use App\Services\User\ReleaseAuctionMoneyService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BuyerShippingDetailController extends Controller
{
    public function create(Auction $auction)
    {

        $data['auction'] = $auction;

        if( $auction->status == AUCTION_STATUS_COMPLETED && auth()->check() ) {
            $data['winner'] = $auction->getWinner()
                ->where('user_id', auth()->id())
                ->first();
        }

        if (is_null($data['winner']) || $data['winner']->user_id != auth()->user()->id) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Access Denied'));
        }

        $submittedDay = Carbon::parse($data['auction']->delivery_date);
        $disputeDays = settings('dispute_time');
        $data['reportWithIn'] = $submittedDay->addDays($disputeDays);

        $data['carbon'] = new Carbon();
        $data['addresses'] = auth()->user()->addresses;
        $data['productReceivingAddress'] = Address::where('id', $data['auction']->address_id)->first();

        $data['countries'] = Country::get()->pluck('name', 'id')->toArray();
        $data['title'] = __('Shipping Description');

        return view('seller.auction.shipping_description', $data);

    }

    public function update(ShippingDescriptionRequest $request, Auction $auction)
    {
        if (
            $auction->status != AUCTION_STATUS_COMPLETED &&
            $auction->getWinner &&
            $auction->getWinner->user_id != auth()->id()
        ) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Invalid request!'));
        }

        if ( is_null($auction->address_id) ) {
            try{
                DB::beginTransaction();

                $addressId = $request->get('address_id');

                if( $request->get('address_id') < 1 ) {
                    $addressAttribute = $request->validated();
                    $addressAttribute['is_verified'] = VERIFICATION_STATUS_UNVERIFIED;
                    $addressId = auth()->user()->addresses()->create($addressAttribute)->id;
                } else {
                    $isAddressUpdated = Address::where('id', $addressId)
                        ->update(['delivery_instruction' => $request->delivery_instruction]);

                    if( !$isAddressUpdated ) {
                        throw new \Exception(__('Failed to update auction shipping address.'));
                    }
                }

                $isAuctionUpdated = $auction->update(['address_id' => $addressId]);

                if( !$isAuctionUpdated ) {
                    throw new \Exception(__('Failed to update auction.'));
                }

                $date = now();
                $route = route('auction.show', $auction->ref_id);
                $notificationAttributes = [
                    'user_id' => $auction->seller->user->id,
                    'message' => __('Winner of :auction auction :winner has submitted the shipping address', [
                        'auction' => '<strong>' . $auction->title . '</strong>',
                        'winner' => '<strong>' . $auction->title . '</strong>']),
                    'link' => $route,
                    'updated_at' => $date,
                    'created_at' => $date
                ];

                Notification::create($notificationAttributes);

                DB::commit();

                return redirect()
                    ->route('shipping-description.create', $auction->ref_id)
                    ->withInput()
                    ->with(RESPONSE_TYPE_SUCCESS, __('The shipping address has been submitted successfully.'));
            }
            catch (\Exception $exception) {
                DB::rollBack();
                Logger::error($exception, '[FAILED][BuyerShippingDetailController][update]');
            }
        }

        return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed to submit your shipping description'));
    }

    public function confirmProductReceived(Auction $auction)
    {
        if (
            $auction->status != AUCTION_STATUS_COMPLETED ||
            $auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED ||
            optional($auction->getWinner)->user_id != auth()->id()
        ) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Invalid request!'));
        }

        $releaseMoney = app(ReleaseAuctionMoneyService::class)->releaseAuctionMoney($auction);

        if ( $releaseMoney ) {
            return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('The confirmation has been made successfully.'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to confirm. Please try sometime later.'));
    }
}
