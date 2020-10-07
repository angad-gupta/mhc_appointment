<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Schedule::class, function (Faker $faker) {
    return [
        'day'   =>  1,
        'day_index' =>  $faker->numberBetween(1,7),
        'doctor_id' =>  1,
    ];
});
