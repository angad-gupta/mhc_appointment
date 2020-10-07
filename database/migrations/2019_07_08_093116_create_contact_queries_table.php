<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_queries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name', 250);
            $table->string('email_address', 250);
            $table->string('subject', 250);
            $table->longText('message');
            $table->boolean('checked')->default(false);
            $table->integer('contact_query_id')->nullable();
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
        Schema::dropIfExists('contact_queries');
    }
}
