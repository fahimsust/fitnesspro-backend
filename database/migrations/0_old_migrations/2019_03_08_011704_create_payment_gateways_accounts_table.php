<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gateways_accounts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('gateway_id');
            $table->string('name', 55);
            $table->string('login_id', 35);
            $table->string('password', 35);
            $table->string('transaction_key');
            $table->boolean('use_cvv');
            $table->string('currency_code', 4);
            $table->boolean('use_test');
            $table->text('custom_fields');
            $table->boolean('limitby_country')->comment('0=no,1=billing,2=shipping,3=billing not,4=shipping not');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_gateways_accounts');
    }
};
