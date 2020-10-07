<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_id');
            $table->text('chief_complains')->nullable();
            $table->text('on_examinations')->nullable();
            $table->text('provisional_diagnosis')->nullable();
            $table->text('differential_diagnosis')->nullable();
            $table->text('lab_workup')->nullable();
            $table->text('advices')->nullable();
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
        Schema::dropIfExists('prescription_inspections');
    }
}
