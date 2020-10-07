<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day',250);
            $table->string('day_index',250);
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('created_by');
            $table->timestamps();
        });

        /*Schema::table('schedules',function ($table){
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('created_by')->references('id')->on('users');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
