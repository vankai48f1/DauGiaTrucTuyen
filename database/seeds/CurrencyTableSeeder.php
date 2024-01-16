<?php

use App\Models\Auction\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'name' => 'United States Dollar',
                'symbol' => 'USD',
                'type' => CURRENCY_TYPE_FIAT,
            ],
            [
                'name' => 'Bangladeshi Taka',
                'symbol' => 'BDT',
                'type' => CURRENCY_TYPE_FIAT,
            ],
        ];

        foreach( $currencies as $currency ) {
            factory(Currency::class)->create($currency);
        }
    }
}
