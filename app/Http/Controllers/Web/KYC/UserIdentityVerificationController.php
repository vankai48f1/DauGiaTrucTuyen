<?php

namespace App\Http\Controllers\Web\KYC;

use App\Http\Controllers\Controller;
use App\Http\Requests\KYC\UserIdentityVerificationRequest;
use App\Services\Core\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserIdentityVerificationController extends Controller
{
    public function index()
    {
        $data['identity'] = auth()->user()->identity;
        $data['title'] = __('My Identity');

        if ($data['identity']) {
            return view('kyc.user.identity.show', $data);
        } else {
            return view('kyc.user.identity.create', $data);
        }
    }

    public function store(UserIdentityVerificationRequest $request)
    {
        if (empty(auth()->user()->identity)) {
            if ($request->hasFile('front_image')) {
                $frontImage = app(FileUploadService::class)
                    ->upload(
                        $request->file('front_image'),
                        config('commonconfig.know_your_customer_images'),
                        'front_image',
                        'knowYourCustomer',
                        Str::uuid(),
                        'public'
                    );
            }

            if ($request->hasFile('back_image')) {
                $backImage = app(FileUploadService::class)
                    ->upload(
                        $request->file('back_image'),
                        config('commonconfig.know_your_customer_images'),
                        'back_image',
                        'knowYourCustomer',
                        Str::uuid(),
                        'public'
                    );
            }

            $attributes = [
                'status' => VERIFICATION_STATUS_PENDING,
                'front_image' => isset($frontImage) ? $frontImage : null,
                'back_image' => isset($backImage) ? $backImage : null,
                'verification_type' => VERIFICATION_TYPE_ID,
                'identification_type' => $request->identification_type,
            ];

            if ( auth()->user()->identity()->create($attributes) ) {
                return redirect()
                    ->route('kyc.identity.index')
                    ->with(RESPONSE_TYPE_SUCCESS, __('The address verification request has been created successfully.'));
            }
        }

        return redirect()
            ->back()
            ->withInput()
            ->with(RESPONSE_TYPE_ERROR, __('Failed to submit the identity verification request.'));
    }
}
