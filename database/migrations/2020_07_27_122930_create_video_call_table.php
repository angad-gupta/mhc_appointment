<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoCallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_call', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appointment_id');
            $table->string('room_id');
            $table->integer('patient_id');
            $table->integer('doctor_id');
            $table->tinyInteger('status')->default(0);
            $table->string('call_duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_call');
    }
}
