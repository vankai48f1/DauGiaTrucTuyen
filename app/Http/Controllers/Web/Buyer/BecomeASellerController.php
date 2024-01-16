<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SellerProfileRequest;
use App\Models\User\Address;
use App\Models\User\Seller;
use App\Services\Core\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BecomeASellerController extends Controller
{
    public function create()
    {
        $checkSeller = Seller::where('user_id', auth()->id())->first();
        abort_if($checkSeller, 401);

        $data['title'] = __('Create a store');
        $data['addresses'] = app(Address::class)->where(['ownerable_id' => Auth::user()->id]);

        return view('seller.stores.create', $data);
    }

    public function store(SellerProfileRequest $request): RedirectResponse
    {
        if (auth()->user()->seller) {
            return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('You already have a store'));
        }

        $parameters = $request->validated();
        $parameters['user_id'] = auth()->user()->id;
        $parameters['ref_id'] = Str::uuid();

        if ($request->hasFile('image')) {
            $image = app(FileUploadService::class)->upload($request->file('image'), config('commonconfig.seller_profile_images'), 'image', 'seller', Str::uuid(), 'public', 320, 300);

            if (!empty($image)) {
                $parameters['image'] = $image;
            }

        }

        DB::beginTransaction();

        Seller::create($parameters);

        $isUpdated = Auth::user()->update([
            'assigned_role' => USER_ROLE_SELLER
        ]);

        if ($isUpdated) {
            DB::commit();

            return redirect()
                ->route('seller.store.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('Store has been created Successfully'));
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to create the store'));
    }
}
