<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('search_id',250);
            $table->integer('doctor_id');
            $table->integer('patient_id');
            $table->integer('schedule_id')->nullable();
            $table->date('schedule_date');
            $table->string('schedule_time',250)->nullable();
            $table->date('next_followup')->nullable();
            $table->tinyInteger('follow_up_status')->default(0)->comment('0=nothing,1=Contacted,2=Appointed');
            $table->integer('prev_appointment_id')->nullable();
            $table->integer('next_appointment_id')->nullable();
            $table->text('note')->nullable();
            $table->integer('created_by');
            $table->tinyInteger('status')->default(1)->comment('0=Cancel,1=Pending,2=Complete');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
