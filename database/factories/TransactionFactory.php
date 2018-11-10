<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [

        'title' => $faker->title,
        'amount' => $faker->numberBetween(),
        'type' => 'income'

    ];
});
