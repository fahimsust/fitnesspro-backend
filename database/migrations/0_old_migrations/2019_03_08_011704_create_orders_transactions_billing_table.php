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
        Schema::create('orders_transactions_billing', function (Blueprint $table) {
            $table->integer('orders_transactions_id')->primary();
            $table->string('bill_first_name', 35);
            $table->string('bill_last_name', 35);
            $table->string('bill_address_1', 85);
            $table->string('bill_address_2', 85);
            $table->string('bill_city', 35);
            $table->integer('bill_state_id');
            $table->string('bill_postal_code', 15);
            $table->integer('bill_country_id');
            $table->string('bill_phone', 15);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_transactions_billing');
    }
};
