<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',250);
            $table->boolean('status')->default(1)->comment('1=Active,2=InActive');
            $table->unsignedInteger('created_by');
            $table->timestamps();
            $table->softDeletes();
        });

       /* Schema::table('departments',function (Blueprint $table){
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
        Schema::dropIfExists('departments');
    }
}
