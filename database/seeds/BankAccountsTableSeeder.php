<?php

use App\Models\Core\User;
use App\Models\User\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::cursor() as $user) {
            factory(BankAccount::class, 2)->create(['user_id' => $user->id]);
        }
    }
}
