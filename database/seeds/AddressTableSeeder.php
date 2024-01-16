<?php

use App\Models\Core\User;
use App\Models\User\Address;
use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $users = User::where('assigned_role', 2)->with('profile')->get();
        foreach ($users as $user) {
            factory(Address::class, random_int(1,3))->create([
                'name' => $user->profile->full_name,
                'ownerable_type' =>get_class($user),
                'ownerable_id' => $user->id,
            ]);
        }
    }
}
