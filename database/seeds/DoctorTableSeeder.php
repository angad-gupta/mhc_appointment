<?php

use Illuminate\Database\Seeder;

class DoctorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Doctor::class, 10)->create()->each(function ($doctor) {
            $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            foreach ($days as $key => $day) {
                factory(\App\Models\Schedule::class, 1)->create([
                    'day' => $day,
                    'day_index' => $key,
                    'doctor_id' => $doctor->id,
                ]);
            }
        });
    }
}
