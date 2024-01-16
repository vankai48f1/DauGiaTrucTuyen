<?php

/** @var Factory $factory */

use App\Models\User\Auction;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Carbon;

$factory->define(Auction::class, function (Faker $faker) {
    return [
        'title' => $faker->paragraph('1'),
        'ref_id' => $faker->md5,
        'seller_id' => 3,
        'auction_type' => $faker->numberBetween(1,4),
        'category_id' => rand(1, 10),
        'currency_symbol' => 'USD',
        'starting_date' => Carbon::now(),
        'ending_date' => Carbon::now()->addDays(random_int(1,30)),
        'bid_initial_price' => $faker->numberBetween(50,100),
        'bid_increment_dif' => $faker->numberBetween(1, 10),
        'product_description' => $faker->paragraph,
        'images' => ["34_images_".$faker->numberBetween(0, 4).".jpg", "34_images_".$faker->numberBetween(0, 4).".jpg", "34_images_".$faker->numberBetween(0, 4).".jpg"],
        'is_shippable' => ACTIVE_STATUS_ACTIVE,
        'shipping_type' => SHIPPING_TYPE_FREE,
        'shipping_description' => $faker->text,
        'terms_description' => $faker->text,
        'status' => AUCTION_STATUS_RUNNING,
        'is_multiple_bid_allowed' => ACTIVE_STATUS_ACTIVE,
    ];
});
