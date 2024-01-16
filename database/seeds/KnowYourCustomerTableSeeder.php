<?php

use App\Models\Core\User;
use App\Models\User\KnowYourCustomer;
use Illuminate\Database\Seeder;

class KnowYourCustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('assigned_role', '>=', 2)->get();
        foreach ($users as $user) {
            factory(KnowYourCustomer::class)->create(['user_id' => $user->id]);
        }

    }
}
