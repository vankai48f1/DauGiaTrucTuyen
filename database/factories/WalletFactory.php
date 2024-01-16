<?php

/** @var Factory $factory */

use App\Models\User\Wallet;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'balance' => $faker->numberBetween($min=5000, $max=10000),
        'on_order' => 0,
        'currency_symbol' => null,
        'is_system' => ACTIVE_STATUS_INACTIVE,
    ];
});
