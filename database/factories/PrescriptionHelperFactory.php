<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\PrescriptionHelper::class, function (Faker $faker) {
    return [
        'helper_text'   =>  $faker->text,
        'category'      =>  $faker->numberBetween(0,6),
        'created_by'    =>  5,
        'public'        =>  0
    ];
});
