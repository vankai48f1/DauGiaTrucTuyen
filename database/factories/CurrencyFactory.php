<?php

/** @var Factory $factory */

use App\Models\Auction\Currency;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Currency::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['United States Dollar']),
        'symbol' => $faker->randomElement(['USD']),
        'deposit_status' => INACTIVE,
        'min_deposit' => 50,
        'is_active' => ACTIVE,
        'withdrawal_status' => INACTIVE,
        'min_withdrawal' => 100,
    ];
});
