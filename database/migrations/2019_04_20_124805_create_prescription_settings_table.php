<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('show_top_left')->default(0);
            $table->text('top_left')->nullable();
            $table->boolean('show_top_right')->default(0);
            $table->text('top_right')->nullable();
            $table->integer('doctor_id');
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
        Schema::dropIfExists('prescription_settings');
    }
}
