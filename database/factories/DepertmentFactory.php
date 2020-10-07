<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Department::class, function (Faker $faker) {
    $department = ['Medicine','Gynecologist','Anaesthetics','Cardiology','Ear nose and throat (ENT)','Endoscopy'];

    return [
        'title' =>  $faker->randomElement($department),
        'created_by'    =>  $faker->numberBetween(1,\App\User::where('role',1)->count()),
    ];
});
