<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',250)->nullable();
            $table->string('full_name',250);
            $table->string('email',250);
            $table->string('phone',250)->nullable();
            $table->string('photo',250)->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('created_by');
            $table->timestamps();
            $table->softDeletes();
        });

       /* Schema::table('admins',function (Blueprint $table){
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
