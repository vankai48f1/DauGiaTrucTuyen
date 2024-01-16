<?php

namespace App\Http\Controllers\Web\KYC;

use App\Http\Controllers\Controller;
use App\Http\Requests\KYC\AddressRequest;
use App\Models\Core\Country;
use App\Models\User\Address;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{
    public function index()
    {

        $data['addresses'] = auth()->user()->addresses;
        $data['title'] = __('My Addresses');

        return view('kyc.user.address.index', $data);
    }

    public function create()
    {
        $data['title'] = __('Create Address');
        $data['countries'] = Country::pluck('name', 'id');

        return view('kyc.user.address.create', $data);
    }

    public function store(AddressRequest $request)
    {
        $attributes = $request->validated();
        $attributes['is_default'] = auth()->user()->addresses->count() < 1 ? ACTIVE : INACTIVE;

        if (auth()->user()->addresses()->create($attributes)) {
            return redirect()
                ->route('kyc.addresses.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('The address has been added successfully.'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to add the address.'));
    }

    public function edit($id)
    {
        $data['address'] = auth()->user()
            ->addresses()
            ->where('id', $id)
            ->firstOrFail();
        $data['title'] = __('Edit Address');
        $data['countries'] = Country::pluck('name', 'id');

        return view('kyc.user.address.edit', $data);
    }

    public function update($id, AddressRequest $request)
    {
        $isUpdated = auth()->user()
            ->addresses()
            ->where('is_verified', VERIFICATION_STATUS_UNVERIFIED)
            ->where('id', $id)
            ->update($request->validated());

        if ($isUpdated) {
            return redirect()
                ->route('kyc.addresses.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('The address has been updated successfully.'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to update the address.'));
    }

    public function destroy($id)
    {
        $isDeleted = auth()->user()
            ->addresses()
            ->where('is_verified', VERIFICATION_STATUS_UNVERIFIED)
            ->where('is_default', INACTIVE)
            ->where('id', $id)
            ->delete();

        if ($isDeleted) {
            return redirect()
                ->route('kyc.addresses.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('The address has been deleted successfully.'));
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to delete the address.'));
    }

    public function toggleDefaultStatus($id)
    {
        DB::beginTransaction();

        $makeInactive = auth()->user()
            ->addresses()
            ->where('is_default', ACTIVE)
            ->update(['is_default' => INACTIVE]);

        $makeActive = auth()->user()
            ->addresses()
            ->where('id', $id)
            ->update(['is_default' => ACTIVE]);

        if ($makeInactive && $makeActive) {
            DB::commit();
            return redirect()
                ->route('kyc.addresses.index')
                ->with(RESPONSE_TYPE_SUCCESS, __('The default status has been changed successfully.'));
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to change the default status.'));
    }
}
