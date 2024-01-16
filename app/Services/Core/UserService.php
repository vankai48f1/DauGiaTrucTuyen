<?php

namespace App\Services\Core;

use App\Models\Core\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function generate($parameters)
    {
        $userParams = Arr::only($parameters, ['email', 'username', 'is_email_verified', 'is_financial_active', 'is_accessible_under_maintenance', 'status', 'created_by', 'password']);

        $userParams['password'] = Hash::make($userParams['password']);
        $userParams['assigned_role'] = settings('default_role_to_register');

        if (Arr::has($parameters, 'assigned_role')) {
            $userParams['assigned_role'] = $parameters['assigned_role'];
        }

        if (Arr::has($parameters, 'is_super_admin')) {
            $userParams['is_super_admin'] = $parameters['is_super_admin'];
        }

        DB::beginTransaction();
        $user = User::create($userParams);

        if (empty($user)) {
            DB::rollBack();
            return false;
        }

        $profileParams = Arr::only($parameters, ['first_name', 'last_name', 'address', 'phone']);
        $profile = $user->profile()->create($profileParams);

        if (empty($profile)) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return $user;
    }
}
