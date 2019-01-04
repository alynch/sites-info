<?php

use Faker\Generator as Faker;

$factory->define(App\UnitType::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'code' => $faker->unique()->word,
        'sort_order' => $faker->unique()->randomDigit
    ];
});
