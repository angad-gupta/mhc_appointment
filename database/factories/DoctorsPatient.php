<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\DoctorsPatients::class, function (Faker $faker) {
    return [
        'doctor_id'     =>  $faker->numberBetween(1,\App\Models\Doctor::count()),
        'patient_id'    =>  $faker->numberBetween(1,\App\Models\Patient::count()),
        'created_by'    =>  1
    ];
});
