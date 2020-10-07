<?php

use Illuminate\Database\Seeder;

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Patient::class,4000)->create()->each(function ($patient){
            factory(\App\Models\DoctorsPatients::class,1)->create([
                'patient_id'    =>  $patient->id
            ]);
        });
    }
}
