<?php

use Faker\Generator as Faker;
use App\Models\Good;

$factory->define(Good::class, function (Faker $faker) {
    return [
        'title' => $faker->text(32),
        'description' => $faker->text(255),
        'price' => $faker->randomFloat(2, 0, 1000),
    ];
});
