<?php

use App\Models\Auction\Currency;
use App\Models\Core\User;
use App\Models\User\Wallet;
use Illuminate\Database\Seeder;

class WalletTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $currencies = Currency::all();
        foreach ($currencies as $currency) {
            foreach ($users as $user) {
                factory(Wallet::class)->create([
                    'user_id' => $user->id,
                    'currency_symbol' => $currency->symbol
                ]);
            }
        }
    }
}
