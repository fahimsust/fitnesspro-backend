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
        Schema::create('payment_gateways_accounts_limitcountries', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('gateway_account_id');
            $table->integer('country_id');
            $table->unique(['gateway_account_id', 'country_id'], 'pagaacli_gateway_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_gateways_accounts_limitcountries');
    }
};
