<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->tinyInteger('video_consultation')->default(0);
            $table->text('services')->nullable();
            $table->text('location')->nullable();
            $table->string('nmc_number')->nullable();
            $table->smallInteger('experience')->nullable();
            $table->enum('doctor_status',['approved','rejected','pending'])->default('pending');
            $table->unsignedDecimal('video_consultation_fee', 8, 2)->nullable();
            $table->unsignedDecimal('normal_consultation_fee', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('video_consultation');
            $table->dropColumn('services');
            $table->dropColumn('location');
            $table->dropColumn('nmc_number');
            $table->dropColumn('experience');
            $table->dropColumn('doctor_status');
            $table->dropColumn('video_consultation_fee');
            $table->dropColumn('normal_consultation_fee');

        });
    }
}
