<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('about_us')->nullable();
            $table->string('about_us_video',250)->nullable();
            $table->string('about_us_image',250)->nullable();
            $table->longText('opening_hours')->nullable();
            $table->tinyInteger('image_or_video')->nullable()->comment('1=Image,2=Video');
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
        Schema::dropIfExists('abouts');
    }
}
