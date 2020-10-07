<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id');
            $table->integer('doctor_id');
            $table->integer('appointment_id')->nullable();
            $table->integer('payment_type')->default(1)->comment('1=Cash,2=Bank,3=Card');
            $table->text('payment_info')->nullable();
            $table->double('payment_amount')->default(0);
            $table->integer('created_by');
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
        Schema::dropIfExists('patient_payments');
    }
}
