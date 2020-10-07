<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Doctor::class, function (Faker $faker) {
    $email = $faker->unique()->safeEmail;
    return [
        'title' => 'Dr ' . $faker->title,
        'full_name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'sex' => $faker->randomElement(['Male', 'Female', 'Other']),
        'department_id' => $faker->numberBetween(1, \App\Models\Department::count()),
        'user_id' => factory(\App\User::class)->create([
            'user_name' => 'doctor' . \Carbon\Carbon::now()->timestamp,
            'full_name' => $faker->name,
            'email' => $email,
            'role' => 2
        ])->id,
        'created_by' => 1
    ];
});

