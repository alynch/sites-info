<?php

use Faker\Generator as Faker;

$factory->define(App\Unit::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'short_name' => $faker->name,
        'code' => $faker->unique()->word,
        'type_id' => function () {
            return factory(App\UnitType::class)->create()->id;
        }
    ];
});
