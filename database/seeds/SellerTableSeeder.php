<?php

use App\Models\Core\User;
use App\Models\User\Address;
use App\Models\User\Auction;
use App\Models\User\Seller;
use Illuminate\Database\Seeder;

class SellerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('assigned_role', 'user')->with('profile')->get();
        foreach ($users as $user) {
            $seller = factory(Seller::class)->create(['user_id' => $user->id]);
            $seller->auctions()->saveMany(factory(Auction::class, 2)->make());
            $seller->addresses()->save(factory(Address::class)->make([
                'name' => $user->profile->full_name,
                'ownerable_type' =>get_class($seller),
                'ownerable_id' => $seller->id,
            ]));
        }
    }
}
