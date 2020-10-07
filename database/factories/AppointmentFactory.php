<?php

use App\Models\Appointment;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(\App\Models\Appointment::class, function (Faker $faker) {
    $doctor_id = $faker->randomElement(\App\Models\Doctor::pluck('id')->toArray());
    $patient_id = $faker->randomElement(\App\Models\Patient::pluck('id')->toArray());

    return [
        'search_id' => 'A' . str_pad(Appointment::count() + 1, 4, '0', STR_PAD_LEFT) . $doctor_id . $patient_id . Carbon::now()->format('dmy'),
        'doctor_id' => $doctor_id,
        'patient_id' => $patient_id,
        'schedule_date' => $faker->dateTimeBetween('now', '+1   years'),
        'schedule_time' => '10 Am to 20 Pm',
        'created_by' => 1
    ];
});
