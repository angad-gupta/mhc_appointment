<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin
        factory(\App\Models\Admin::class, 5)->create();

        // Create Department
        factory(\App\Models\Department::class, 6)->create();


        $this->call([
            // Create Doctor
            DoctorTableSeeder::class,



            // Create patient
            PatientTableSeeder::class
        ]);

        // Create Drug
        factory(\App\Models\Drug::class, 1000)->create();


    }
}
