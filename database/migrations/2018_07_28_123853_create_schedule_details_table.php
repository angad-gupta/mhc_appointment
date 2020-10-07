<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('schedule_id');
            $table->string('start_time',250);
            $table->string('end_time',250)->nullable();
            $table->unsignedInteger('created_by');
            $table->timestamps();
            $table->softDeletes();
        });

      /*  Schema::table('schedule_details',function ($table){
            $table->foreign('schedule_id')->references('id')->on('schedules');
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
        Schema::dropIfExists('schedule_details');
    }
}
