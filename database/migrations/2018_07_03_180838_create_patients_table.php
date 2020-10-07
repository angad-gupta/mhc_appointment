<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',250);
            $table->string('full_name',250);
            $table->string('photo',250)->nullable();
            $table->string('contact_email',250)->nullable();
            $table->date('date_of_birth');
            $table->string('sex',250)->default(1)->comment('1=Male,2=Female,3=Other');
            $table->string('occupation',250)->nullable();
            $table->string('height',250)->nullable();
            $table->string('weight',250)->nullable();
            $table->string('cell_phone',250)->nullable();
            $table->string('home_phone',250)->nullable();
            $table->string('country',250)->nullable();
            $table->string('city',250)->nullable();
            $table->text('address')->nullable();
            $table->integer('user_id')->nullable();
            $table->unsignedInteger('created_by');
            $table->timestamps();
        });

       /* Schema::table('patients',function (Blueprint $table){
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
        Schema::dropIfExists('patients');
    }
}
