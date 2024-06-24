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
        Schema::create('accounts_discounts_used', function (Blueprint $table) {
            $table->integer('account_id')->index('adisc_account_id');
            $table->integer('discount_id')->index('adisc_discount_id');
            $table->integer('order_id')->index('adisc_order_id');
            $table->integer('times_used');
            $table->dateTime('used');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_discounts_used');
    }
};
