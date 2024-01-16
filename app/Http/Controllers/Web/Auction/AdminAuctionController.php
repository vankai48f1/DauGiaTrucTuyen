<?php

namespace App\Http\Controllers\Web\Auction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auction\AdminAuctionRequest;
use App\Http\Requests\User\AuctionRequest;
use App\Models\Auction\Category;
use App\Models\Auction\Currency;
use App\Models\User\Auction;
use App\Services\Core\DataTableService;
use App\Services\Core\FileUploadService;
use App\Services\User\ReleaseAuctionMoneyService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminAuctionController extends Controller
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
            ['auctions.status', __('Status'), auction_status()],
            ['auctions.product_claim_status', __('Product Claim Status'), product_claim_status()],
        ];

        $queryBuilder = Auction::query()
            ->with('seller')
            ->orderByDesc('created_at');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filters)
            ->create($queryBuilder);

        $data['title'] = __('Auction List');

        return view('auction.admin.index', $data);
    }

    public function edit(Auction $auction)
    {
        if(!in_array($auction->status, [AUCTION_STATUS_DRAFT, AUCTION_STATUS_RUNNING])) {
            return redirect()
                ->route('admin.auctions.index')
                ->with(RESPONSE_TYPE_ERROR, __('The auction can not be edited.'));
        }

        $data['auction'] = $auction;
        $data['categories'] = Category::pluck('name', 'id');
        $data['currencies'] = Currency::where('is_active', ACTIVE_STATUS_ACTIVE)
            ->pluck('name', 'symbol');
        $data['title'] = __('Edit Auction');

        return view('auction.admin.edit', $data);
    }

    public function update(AdminAuctionRequest $request, Auction $auction)
    {
        if(!in_array($auction->status, [AUCTION_STATUS_DRAFT, AUCTION_STATUS_RUNNING])) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('The auction can not be edited as completed.'));
        }

        $parameters = $request->validated();

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
                ->route('admin.auctions.edit', $auction->id)
                ->with(RESPONSE_TYPE_SUCCESS, __('The auction been updated successfully'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to update Auction'));
    }

    public function releaseSellerMoney($id)
    {
        $currentAuction = Auction::where('id', $id)
            ->where('status', AUCTION_STATUS_COMPLETED)
            ->first();

        if ($currentAuction->bids->count() <= 0) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('No bidder found, No Buyer posted any offer'));
        }

        if ($currentAuction->product_claim_status == AUCTION_PRODUCT_CLAIM_STATUS_DELIVERED) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Money already released'));
        }

        $releaseMoney = app(ReleaseAuctionMoneyService::class)->releaseAuctionMoney($id);
        if (!$releaseMoney) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to release the money'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_SUCCESS, __('Money release has been successful'));

    }
}
