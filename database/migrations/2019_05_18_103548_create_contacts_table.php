<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone',250)->nullable();
            $table->string('mail',250)->nullable();
            $table->text('address')->nullable();
            $table->longText('google_map')->nullable();
            $table->string('fb_link',250)->nullable();
            $table->string('twitter_link',250)->nullable();
            $table->string('linked_in_link',250)->nullable();
            $table->string('instragram_link',250)->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
