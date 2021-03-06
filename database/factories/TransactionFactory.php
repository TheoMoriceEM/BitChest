<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'currency_id' => $faker->numberBetween(1, 10),
        'user_id' => $faker->numberBetween(1, 10),
        'quantity' => $faker->randomFloat(6, 0.001, 3),
        'purchase_price' => $faker->randomFloat(6, 0.05, 5000),
        'purchase_date' => $faker->dateTimeBetween('-1 year'),
        'sold' => $faker->boolean,
        'selling_price' => $faker->randomFloat(6, 0.05, 5000),
        'selling_date' => $faker->dateTimeBetween('now', '+1 year')
    ];
});
