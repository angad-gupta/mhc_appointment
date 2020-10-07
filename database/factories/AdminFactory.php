<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Admin::class, function (Faker $faker) {
    $email = $faker->unique()->safeEmail;
    return [
        'title' => $faker->title,
        'full_name' => $faker->name,
        'email' => $email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'user_id' => factory(\App\User::class)->create([
            'user_name' => 'admin' . \Carbon\Carbon::now()->timestamp,
            'full_name' =>  $faker->name,
            'email' => $email,
            'role' => 1
        ])->id,
        'created_by' => 1,
    ];
});
