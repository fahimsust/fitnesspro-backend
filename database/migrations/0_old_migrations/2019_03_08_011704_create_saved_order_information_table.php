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
        Schema::create('saved_order_information', function (Blueprint $table) {
            $table->integer('order_id', true);
            $table->string('order_email', 85);
            $table->integer('account_billing_id');
            $table->integer('account_shipping_id');
            $table->string('bill_first_name', 35);
            $table->string('bill_last_name', 35);
            $table->string('bill_address_1', 85);
            $table->string('bill_address_2', 85);
            $table->string('bill_city', 35);
            $table->integer('bill_state_id');
            $table->string('bill_postal_code', 15);
            $table->integer('bill_country_id');
            $table->string('bill_phone', 15);
            $table->boolean('is_residential');
            $table->string('ship_company', 155);
            $table->string('ship_first_name', 35);
            $table->string('ship_last_name', 35);
            $table->string('ship_address_1', 85);
            $table->string('ship_address_2', 85);
            $table->string('ship_city', 35);
            $table->integer('ship_state_id');
            $table->string('ship_postal_code', 15);
            $table->integer('ship_country_id');
            $table->string('ship_email', 85);
            $table->integer('payment_method_id');
            $table->integer('shipping_method_id');
            $table->tinyInteger('step');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_order_information');
    }
};
