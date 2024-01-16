<?php

namespace App\Http\Controllers\Web\KYC;

use App\Http\Controllers\Controller;
use App\Http\Requests\KYC\AddressVerificationRequest;
use App\Models\User\KnowYourCustomer;
use App\Services\Core\FileUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerAddressVerificationController extends Controller
{
    public function create($id)
    {

        $data['address'] = auth()->user()
            ->seller
            ->addresses()
            ->where('id', $id)
            ->where('is_verified', VERIFICATION_STATUS_UNVERIFIED)
            ->firstOrFail();

        $data['title'] = __('Submit Address Verification');

        return view('kyc.seller.address.verification.create', $data);
    }

    public function store(AddressVerificationRequest $request, $address)
    {
        $sellerAddress = auth()->user()
            ->seller
            ->addresses()
            ->where('is_verified', VERIFICATION_STATUS_UNVERIFIED)
            ->where('id', $address)
            ->firstOrFail();

        if (empty($sellerAddress->knowYourCustomer)) {
            $frontImage = app(FileUploadService::class)
                ->upload(
                    $request->file('front_image'),
                    config('commonconfig.know_your_customer_images'),
                    'front_image',
                    'knowYourCustomer',
                    Str::uuid(),
                    'public'
                );

            if (!empty($frontImage)) {
                DB::beginTransaction();

                $isCreated = $sellerAddress->knowYourCustomer()->create([
                    'user_id' => auth()->id(),
                    'status' => VERIFICATION_STATUS_PENDING,
                    'front_image' => $frontImage,
                    'verification_type' => VERIFICATION_TYPE_ADDRESS,
                    'identification_type' => $request->identification_type,
                ]);

                if ($sellerAddress->update(['is_verified' => VERIFICATION_STATUS_PENDING])) {
                    DB::commit();
                    return redirect()
                        ->route('kyc.seller.addresses.verification.show', [
                            'address' => $sellerAddress->id,
                            'verification' => $isCreated->id
                        ])
                        ->with(RESPONSE_TYPE_SUCCESS, __('The address verification request has been created successfully.'));
                }

                DB::rollBack();
            }
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to create the address verification request.'));
    }

    public function show($address, $verification)
    {
        $data['verification'] = KnowYourCustomer::where('id', $verification)
            ->where('address_id', $address)
            ->where('user_id', auth()->id())
            ->where('verification_type', VERIFICATION_TYPE_ADDRESS)
            ->with('address')
            ->firstOrFail();
        $data['title'] = __('Address Verification');

        return view('kyc.seller.address.verification.show', $data);
    }
}
