<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AuctionRequest;
use App\Http\Requests\User\ShippingDescriptionRequest;
use App\Models\Auction\Category;
use App\Models\Auction\Currency;
use App\Models\Core\Country;
use App\Models\Core\Notification;
use App\Models\Core\User;
use App\Models\User\Address;
use App\Models\User\Auction;
use App\Models\User\Bid;
use App\Models\User\KnowYourCustomer;
use App\Services\Core\FileUploadService;
use App\Services\Logger\Logger;
use App\Services\User\ReleaseAuctionMoneyService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerAuctionController extends Controller
{

    public function create()
    {
        $seller = Auth::user()->seller;
        abort_if(!$seller, 404);

        $data['seller'] = $seller;
        $data['isAddressVerified'] = KnowYourCustomer::where('user_id', $seller->user_id)
            ->where('status', VERIFICATION_STATUS_APPROVED)
            ->first();
        $data['categories'] = Category::pluck('name', 'id');
        $data['currencies'] = Currency::where('is_active', ACTIVE_STATUS_ACTIVE)
            ->pluck('name', 'symbol');
        $data['title'] = __('Create Auction');

        return view('seller.auction.create', $data);
    }

    public function store(AuctionRequest $request)
    {
        $seller = Auth::user()->seller;

        if (empty($seller)) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Access Denied'));
        }

        if (!$seller->addresses()->where('is_verified', VERIFICATION_STATUS_APPROVED)->first()) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Seller address verification is required to create an auction'));
        }

        $parameters = $request->validated();
        $parameters['ref_id'] = Str::uuid();

        if ($request->has('meta_keywords')) {
            $parameters['meta_keywords'] = $request->get('meta_keywords');
        }

        $parameters['seller_id'] = Auth::user()->seller->id;

        $new_name = 0;
        $uploadedImage = [];

        if (!empty($request->images)) {
            foreach ($request->images as $file) {
                $uploadedImage[] = app(FileUploadService::class)->upload($file, config('commonconfig.auction_image'), Str::slug($request->get('title')), '', $new_name++, 'public', 600, 400);
            }
        }

        if (!empty($uploadedImage)) {
            $parameters['images'] = $uploadedImage;
        }

        $auction = Auction::create($parameters);

        if ($auction) {
            return redirect()->route('auction.show', $auction->ref_id)->with(RESPONSE_TYPE_SUCCESS, __('Auction has been created successfully'));
        }

        return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed to create Auction'));
    }

    public function edit(Auction $auction)
    {
        abort_if($auction->status != AUCTION_STATUS_DRAFT, 404);
        abort_if($auction->seller_id != auth()->user()->seller->id, 404);
        $data['auction'] = $auction;
        $data['categories'] = Category::pluck('name', 'id');
        $data['currencies'] = Currency::where('is_active', ACTIVE_STATUS_ACTIVE)
            ->pluck('name', 'symbol');
        $data['title'] = __('Edit Auction');

        return view('seller.auction.edit', $data);
    }

    public function update(AuctionRequest $request, Auction $auction)
    {
        if ($auction->seller_id != auth()->user()->seller->id) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Access Denied'));
        }

        $parameters = $request->validated();

//        $new_name = count($auction->images) + 1;

        $uploadedImage = [];

        if ($request->has('meta_keywords')) {
            $parameters['meta_keywords'] = $request->get('meta_keywords');
        }

        if (!empty($request->old_images)) {
            $oldImages = $auction->images;
            $deleteAbleImages = array_diff($oldImages, $request->old_images);

            foreach ($deleteAbleImages as $deleteAbleImage) {
                Storage::delete(config('commonconfig.auction_image').$deleteAbleImage);
            }
        }

        if (!empty($request->images)) {
            foreach ($request->images as $file) {
                $uploadedImage[] = app(FileUploadService::class)->upload($file, config('commonconfig.auction_image'), Str::slug($request->get('title')), '', random_string(10), 'public', 600, 400);
            }
        }


        if (!empty($uploadedImage)) {
            if(!empty($request->old_images)) {
                $parameters['images'] = array_merge($uploadedImage, $request->old_images);
            } else {
                $parameters['images'] = $uploadedImage;
            }
        }
        else{
            $parameters['images'] = $request->old_images;
        }

        if ($auction->update($parameters)) {
            return redirect()
                ->route('auction.edit', $auction->id)
                ->with(RESPONSE_TYPE_SUCCESS, __('The Auction has been updated successfully'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to update Auction'));
    }

    public function start(Auction $auction)
    {
        abort_if($auction->seller_id != auth()->user()->seller->id, 404);

        if ($auction->status != AUCTION_STATUS_DRAFT) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('The auction can not be started running.'));
        }

        if ($auction->ending_date < now()) {
            return redirect()
                ->back()
                ->with(RESPONSE_TYPE_ERROR, __('The auction is already date expired. Please modify the ending date.'));
        }

        $isUpdated = $auction->update([
            'status' => AUCTION_STATUS_RUNNING,
            'starting_date' => now()
        ]);

        if ($isUpdated) {
            return redirect()
                ->route('auction.show', $auction->ref_id)
                ->with(RESPONSE_TYPE_SUCCESS, __('The auction has been started running successfully.'));
        }

        return redirect()
            ->back()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to start the auction.'));
    }

    public function releaseSellerMoney(Auction $auction)
    {
        if (
            $auction->status != AUCTION_STATUS_COMPLETED ||
            $auction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED ||
            $auction->seller_id != auth()->user()->seller->id
        ) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Submission has been failed'));
        }

        $releaseMoney = app(ReleaseAuctionMoneyService::class)->releaseAuctionMoney($id);

        if (!$releaseMoney) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to release money'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('Money release has been successful.'));
    }
}
