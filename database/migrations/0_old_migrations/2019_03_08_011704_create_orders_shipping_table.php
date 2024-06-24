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
        Schema::create('orders_shipping', function (Blueprint $table) {
            $table->integer('order_id')->primary();
            $table->string('ship_company', 155);
            $table->string('ship_first_name', 35);
            $table->string('ship_last_name', 35);
            $table->string('ship_address_1', 85);
            $table->string('ship_address_2', 85);
            $table->string('ship_city', 35);
            $table->integer('ship_state_id');
            $table->integer('ship_country_id');
            $table->string('ship_postal_code', 15);
            $table->string('ship_email', 85);
            $table->string('ship_phone', 15);
            $table->boolean('is_residential');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_shipping');
    }
};
