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
        Schema::create('accounts-memberships_payment_methods', function (Blueprint $table) {
            $table->integer('site_id')->index('site_id');
            $table->integer('payment_method_id');
            $table->integer('gateway_account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-memberships_payment_methods');
    }
};
