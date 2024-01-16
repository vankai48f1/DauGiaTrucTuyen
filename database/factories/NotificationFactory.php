<?php

/** @var Factory $factory */

use App\Models\Core\Notification;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 4),
        'message' => $faker->sentence
    ];
});
