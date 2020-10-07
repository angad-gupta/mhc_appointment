<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_id');
            $table->string('type',250)->nullable();
            $table->string('name',250)->nullable();
            $table->string('strength',250)->nullable();
            $table->string('dose',250)->nullable();
            $table->string('advice',250)->nullable();
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
        Schema::dropIfExists('prescription_drugs');
    }
}
