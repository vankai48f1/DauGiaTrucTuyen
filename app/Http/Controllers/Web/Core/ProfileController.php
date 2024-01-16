<?php

namespace App\Http\Controllers\Web\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\{PasswordUpdateRequest, UserAvatarRequest, UserRequest};
use App\Services\Core\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        $data = $this->service->profile();
        $data['title'] = __('Profile');

        return view('user.profile.personal_info.index', $data);
    }

    public function edit(): View
    {
        $data = $this->service->profile();
        $data['title'] = __('Edit Profile');

        return view('core.profile.edit', $data);
    }

    public function update(UserRequest $request): RedirectResponse
    {
        $parameters = $request->only(['first_name', 'last_name', 'address']);
        if (Auth::user()->profile()->update($parameters)) {
            return redirect()->route('profile.edit')->with(RESPONSE_TYPE_SUCCESS, __('Profile has been updated successfully.'));
        }

        return redirect()->back()->with(RESPONSE_TYPE_ERROR, __('Failed to update profile.'));
    }

    public function changePassword(): View
    {
        $data = $this->service->profile();
        $data['title'] = __('Change Password');

        return view('core.profile.change_password', $data);
    }

    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $response = $this->service->updatePassword($request);
        $status = $response[RESPONSE_STATUS_KEY] ? RESPONSE_TYPE_SUCCESS : RESPONSE_TYPE_ERROR;

        return redirect()->back()->with($status, $response[RESPONSE_MESSAGE_KEY]);
    }


    public function avatarEdit(): View
    {
        $data = $this->service->profile();
        $data['title'] = __('Change Avatar');

        return view('core.profile.avatar_edit_form', $data);
    }

    public function avatarUpdate(UserAvatarRequest $request): RedirectResponse
    {
        $response = $this->service->avatarUpload($request);
        $status = $response[RESPONSE_STATUS_KEY] ? RESPONSE_TYPE_SUCCESS : RESPONSE_TYPE_ERROR;

        return redirect()->back()->with($status, $response[RESPONSE_MESSAGE_KEY]);
    }
}
