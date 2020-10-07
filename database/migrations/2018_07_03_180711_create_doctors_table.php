<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',250);
            $table->string('title',250);
            $table->string('full_name',250);
            $table->string('phone',250)->nullable();
            $table->string('photo',250)->nullable();
            $table->string('sex',250)->default(1)->comment('1=Male,2=Female,3=Other');
            $table->text('info')->nullable();
            $table->longText('descriptions')->nullable();
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('created_by');
            $table->timestamps();
        });

       /* Schema::table('doctors',function (Blueprint $table){
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('doctors');
    }
}
