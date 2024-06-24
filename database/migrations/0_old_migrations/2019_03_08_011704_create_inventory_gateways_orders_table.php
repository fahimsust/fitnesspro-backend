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
        Schema::create('inventory_gateways_orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('gateway_account_id');
            $table->string('gateway_order_id', 55);
            $table->integer('shipment_id')->index('shipment_id');
            $table->decimal('total_amount', 10);
            $table->dateTime('created');
            $table->dateTime('modified');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_gateways_orders');
    }
};
