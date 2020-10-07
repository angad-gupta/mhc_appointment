<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trade_name',250);
            $table->string('generic_name',250);
            $table->string('image',250)->nullable();
            $table->longText('note')->nullable();
            $table->integer('department_id');
            $table->boolean('status')->default(1)->comment('1=Active,2=InActive');
            $table->unsignedInteger('created_by');
            $table->timestamps();
        });

       /* Schema::table('drugs',function (Blueprint $table){
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
        Schema::dropIfExists('drugs');
    }
}
