<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoryTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(KnowYourCustomerTableSeeder::class);
        $this->call(WalletTableSeeder::class);
        $this->call(BankAccountsTableSeeder::class);
    }
}
