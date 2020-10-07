<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Patient::class, function (Faker $faker) {
    return [
        'title' =>  $faker->title,
        'full_name' =>  $faker->name,
        'date_of_birth' =>  $faker->date(),
        'sex'   =>  $faker->randomElement(['Male','Female','Other']),
        'cell_phone'    =>  $faker->phoneNumber,
        'country'   =>  'Bangladesh',
        'city'      =>  'Dhaka',
        'address'   =>  $faker->address,
        'created_by'=>  1
    ];
});
