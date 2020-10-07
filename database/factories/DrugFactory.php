<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Drug::class, function (Faker $faker) {
    return [
        'trade_name'    =>  $faker->text(20),
        'generic_name'  =>  $faker->text(40),
        'note'          =>  $faker->text(120),
        'department_id' =>  $faker->numberBetween(1,\App\Models\Department::count())
    ];
});
