<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Feature::class, function (Faker $faker) {

    $name = $faker->name;
    return [
        'name' => $name,
        'type' => $faker->randomElement(['boolean', 'string']),
        'label' => Str::slug($name),
        'description' => $faker->sentence
    ];
});
