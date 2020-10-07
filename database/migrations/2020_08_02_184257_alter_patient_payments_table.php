<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPatientPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_payments', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
        Schema::table('patient_payments', function (Blueprint $table) {
            $table->enum('payment_method',['khalti','esewa','fonepay','ipay','ime-pay','bank'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_payments', function (Blueprint $table) {
            $table->integer('payment_type')->default(1)->comment('1=Cash,2=Bank,3=Card');
        });
        Schema::table('patient_payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
        
        
    }
}
