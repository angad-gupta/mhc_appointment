<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientMedicalDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_medical_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',250)->nullable();
            $table->string('directory',250);
            $table->text('note')->nullable();
            $table->integer('appointment_id');
            $table->integer('patient_id');
            $table->integer('created_by');
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
        Schema::dropIfExists('patient_medical_documents');
    }
}
