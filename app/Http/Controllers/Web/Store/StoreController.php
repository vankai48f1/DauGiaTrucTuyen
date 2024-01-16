<?php

namespace App\Http\Controllers\Web\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SellerProfileRequest;
use App\Models\User\Address;
use App\Models\User\Auction;
use App\Models\User\Seller;
use App\Services\Core\DataTableService;
use App\Services\Core\FileUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreController extends Controller
{

    public function index()
    {
        $checkSeller = Seller::where('user_id', auth()->id())->first();

        if (!$checkSeller) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Access Denied'));
        }

        $conditions = [
            'seller_id' => auth()->user()->seller->id
        ];

        return $this->_list($conditions);
    }

    private function _list($conditions)
    {
        $searchFields = [
            ['title', __('Title')],
            ['auction_type', __('Auction Type')],
        ];

        $orderFields = [
            ['title', __('Title')],
        ];

        $filterFields = [
            ['auction_type', __('Type'), auction_type()],
            ['status', __('Status'), auction_status()],
        ];

        $data['title'] = __('Profile');
        $data['carbon'] = Carbon::parse();
        $data['today'] = Carbon::now();
        $ownerableTypeSeller = get_class(auth()->user()->seller);
        $data['defaultAddress'] = Address::where(['is_default' => ACTIVE_STATUS_ACTIVE, 'ownerable_type' => $ownerableTypeSeller, 'ownerable_id' => auth()->user()->seller->id])->first();

        $queryBuilder = Auction::query()
            ->where($conditions)
            ->with('category')
            ->orderBy('created_at', 'desc');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filterFields)
            ->withoutDateFilter()
            ->create($queryBuilder);

        return view('seller.stores.index', $data);
    }


    public function show(Seller $seller, $status = null)
    {
        $routeName = 'seller.store.show';

        $filters = [
            ['auctions.auction_type', __('Type'), auction_type()],
        ];

        $searchFields = [
            ['title', __('Title')],
        ];

        $orderFields = [
            ['auction_type', __('Type')],
            ['auction_status', __('Status')],
            ['bid_initial_price', __('Starting Price')],
            ['category_id', __('Category')],
            ['currency_id', __('Currency')],
        ];

        $data['title'] = __('Seller Profile');
        $data['routeName'] = $routeName;
        $data['seller'] = $seller;
        $data['isAddressVerified'] = $seller->addresses()
            ->where('is_verified', VERIFICATION_STATUS_APPROVED)
            ->first();

        $queryBuilder = Auction::query()
            ->where('seller_id', $seller->id)
            ->where('status', AUCTION_STATUS_RUNNING)
            ->with('category')
            ->orderBy('created_at', 'desc');

        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filters)
            ->create($queryBuilder);

        return view('seller.stores.show', $data);
    }

    public function edit()
    {
        $data['store'] = Auth::user()->seller;
        $data['addresses'] = Auth::user()->seller->addresses;
        $data['title'] = __('Edit Store Information');

        return view('seller.stores.manage_store.edit', $data);
    }

    public function update(SellerProfileRequest $request)
    {
        $parameters = $request->validated();
        $parameters['user_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = app(FileUploadService::class)->upload(
                $request->file('image'),
                config('commonconfig.seller_profile_images'),
                !empty(auth()->user()->seller->image) ? auth()->user()->seller->image : 'image',
                empty(auth()->user()->seller->image) ? 'seller' : '',
                empty(auth()->user()->seller->image) ? Str::uuid() : '',
                'public',
                320,
                300
            );

            if (!empty($image)) {
                $parameters['image'] = $image;
            }

        }

        if (auth()->user()->seller()->update($parameters)) {
            return redirect()->route('seller.store.index')->with(RESPONSE_TYPE_SUCCESS, __('Store has been created Successfully'));
        }

        return redirect()->back()->withInput()->with(RESPONSE_TYPE_ERROR, __('Failed to create the store'));
    }


}
