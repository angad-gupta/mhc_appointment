<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name',250)->nullable();
            $table->string('user_name',250)->nullable();
            $table->string('photo',250)->nullable();
            $table->string('email',250)->nullable();
            $table->string('password',250);
            $table->integer('role')->default(1)->comment('1=Admin,2=Doctor,3=Patient');
            $table->boolean('status')->default(1)->comment('1=Active,2=InActive');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
