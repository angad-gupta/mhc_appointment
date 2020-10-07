<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvocieSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currency_symbol',250)->default('$');
            $table->string('currency_name',250)->default('dollar');
            $table->longText('invoice_text')->nullable();
            $table->text('address')->nullable();
            $table->string('phone',250)->nullable();
            $table->string('email',250)->nullable();
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
        Schema::dropIfExists('invocie_settings');
    }
}
