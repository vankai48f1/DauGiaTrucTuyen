<?php

use App\Models\Core\User;
use App\Models\Core\UserProfile;
use App\Models\User\Address;
use App\Models\User\Auction;
use App\Models\User\Seller;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::where('is_super_admin', ACTIVE)->first();

        if (empty($superadmin)) {
            factory(User::class, 1)->create([
                'assigned_role' => USER_ROLE_ADMIN,
                'username' => 'superadmin',
                'email' => 'superadmin@codemen.org',
                'password' => Hash::make('superadmin'),
                'is_accessible_under_maintenance' => ACTIVE,
                'is_email_verified' => ACTIVE,
                'is_super_admin' => ACTIVE,
                'status' => STATUS_ACTIVE,
            ])->each(function ($user) {
                $user->profile()->save(factory(UserProfile::class)->make());
            });
        }

        factory(User::class, 1)->create([
            'assigned_role' => USER_ROLE_ADMIN,
            'username' => 'admin',
            'email' => 'admin@codemen.org',
            'password' => Hash::make('admin'),
            'is_accessible_under_maintenance' => ACTIVE,
            'is_email_verified' => ACTIVE,
            'is_super_admin' => INACTIVE,
            'status' => STATUS_ACTIVE,
        ])->each(function ($user) {
            $user->profile()->save(factory(UserProfile::class)->make());
        });

        factory(User::class, 1)->create([
            'assigned_role' => USER_ROLE_SELLER,
            'username' => 'seller',
            'email' => 'seller@codemen.org',
            'password' => Hash::make('seller'),
            'is_accessible_under_maintenance' => INACTIVE,
            'is_email_verified' => ACTIVE,
            'is_super_admin' => INACTIVE,
            'status' => STATUS_ACTIVE,
        ])->each(function ($user) {

            $user->profile()->save(factory(UserProfile::class)->make());
            $seller = $user->seller()->save(factory(Seller::class)->make());
            $user->seller->auctions()->saveMany(factory(Auction::class, 60)->make());
            $user->seller->addresses()->save(factory(Address::class)->make([
                'name' => $user->profile->full_name,
                'ownerable_type' =>get_class($seller),
                'ownerable_id' => $seller->id,
            ]));
        });

        factory(User::class, 1)->create([
            'username' => 'user',
            'email' => 'user@codemen.org',
            'password' => Hash::make('user'),
            'is_accessible_under_maintenance' => INACTIVE,
            'is_email_verified' => ACTIVE,
            'is_super_admin' => INACTIVE,
            'status' => STATUS_ACTIVE,
        ])->each(function ($user) {
            $user->profile()->save(factory(UserProfile::class)->make());
        });

    }
}
