<?php

namespace App\Services\Core;

use App\Http\Requests\Core\{PasswordUpdateRequest, UserAvatarRequest};
use App\Models\Core\Notification;
use Illuminate\Support\Facades\{Auth, Hash};

class ProfileService
{
    public function profile()
    {
        return ['user' => Auth::user()->load('role')];
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $update = ['password' => Hash::make($request->new_password)];

        if (Auth::user()->update($update)) {
            $notification = ['user_id' => Auth::id(), 'message' => __("You just changed your account's password.")];
            Notification::create($notification);

            return [
                RESPONSE_STATUS_KEY => true,
                RESPONSE_MESSAGE_KEY => __('Password has been changed successfully.')
            ];
        }

        return [
            RESPONSE_STATUS_KEY => false,
            RESPONSE_MESSAGE_KEY => __('Failed to change password.')
        ];
    }

    public function avatarUpload(UserAvatarRequest $request)
    {
        $uploadedAvatar = app(FileUploadService::class)->upload($request->file('avatar'), config('commonconfig.path_profile_image'), 'avatar', 'user', Auth::id(), 'public', 300, 300);

        if ($uploadedAvatar) {
            $parameters = ['avatar' => $uploadedAvatar];

            if (Auth::user()->update($parameters)) {
                return [
                    RESPONSE_STATUS_KEY => true,
                    RESPONSE_MESSAGE_KEY => __('Avatar has been uploaded successfully.')
                ];
            }
        }

        return [
            RESPONSE_STATUS_KEY => false,
            RESPONSE_MESSAGE_KEY => __('Failed to upload the avatar.')
        ];
    }
}
