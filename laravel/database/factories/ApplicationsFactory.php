<?php

use Faker\Generator as Faker;

$factory->define(App\Applications::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'group_id' => factory('App\ApplicationGroups')->create(),
        'all_year' => $faker->boolean
    ];
});
