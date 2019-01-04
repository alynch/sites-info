<?php

use Faker\Generator as Faker;

$factory->define(App\Timeline::class, function (Faker $faker) {
    return [
        'application_id' => factory('App\Applications')->create(),
        'start_month' => $faker->month(),
        'start_day' => $faker->dayOfMonth(),
        'end_month' => $faker->month(),
        'end_day' => $faker->dayOfMonth()
    ];
});
