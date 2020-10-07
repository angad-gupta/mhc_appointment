<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePatientParamsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::update("ALTER TABLE `patients` CHANGE `date_of_birth` `date_of_birth` DATE NULL DEFAULT NULL;");
        \DB::update("ALTER TABLE `patients` CHANGE `sex` `sex` VARCHAR(250) NULL DEFAULT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            //
        });
    }
}
