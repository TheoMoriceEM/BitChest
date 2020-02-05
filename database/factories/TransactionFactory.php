<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'fk_currency' => $faker->numberBetween(1, 10),
        'fk_user' => $faker->numberBetween(1, 10),
        'quantity' => $faker->randomFloat(2, 0, 3),
        'purchase_price' => $faker->randomFloat(2, 0, 10000),
        'purchase_date' => $faker->dateTime,
        'sold' => $faker->boolean,
        'selling_amount' => $faker->randomFloat(2, 0, 30000),
        'selling_date' => $faker->dateTimeBetween('now', '+1 year')
    ];
});
