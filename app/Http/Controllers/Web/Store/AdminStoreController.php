<?php

namespace App\Http\Controllers\Web\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\StoreRequest;
use App\Models\User\Dispute;
use App\Models\User\Seller;
use App\Services\Core\DataTableService;
use App\Services\Core\FileUploadService;

class AdminStoreController extends Controller
{
    public function index()
    {
        $searchFields = [
            ['name', __('Store Name')],
            ['email', __('Email')],
            ['phone_number', __('Phone Number')],
        ];
        $orderFields = [
            ['name', __('Store Name')],
            ['email', __('Email')],
            ['phone_number', __('Phone Number')],
            ['created_at', __('Registered Date')],
        ];

        $filters = [
            ['is_active', __('Active Status'), active_status()],
        ];

        $queryBuilder = Seller::orderByDesc('created_at');
        $data['dataTable'] = app(DataTableService::class)
            ->setSearchFields($searchFields)
            ->setOrderFields($orderFields)
            ->setFilterFields($filters)
            ->create($queryBuilder);

        $data['title'] = 'All Seller Store';

        return view('seller.admin.index', $data);
    }

    public function edit(Seller $store)
    {
        $data['store'] = $store;
        $data['title'] = __('Edit Seller Store');

        return view('seller.admin.edit', $data);
    }

    public function update(StoreRequest $request, Seller $store)
    {
        $attributes = $request->validated();

        if ($request->hasFile('image')) {
            $image = app(FileUploadService::class)->upload($request->file('image'), config('commonconfig.seller_profile_images'), 'image', 'seller', microtime(), 'public');

            if (!empty($image)) {
                $attributes['image'] = $image;
            }

        }

        if( $store->update($attributes) )
        {
            return redirect()
                ->route('admin.stores.edit', $store->id)
                ->with(RESPONSE_TYPE_SUCCESS, __('The store has been updated successfully.'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to update the store.'));
    }
}
