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
        Schema::create('orders_shipments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id');
            $table->integer('distributor_id')->index('orsh_distributor_id');
            $table->integer('ship_method_id');
            $table->integer('order_status_id')->default(1);
            $table->string('ship_tracking_no', 40);
            $table->decimal('ship_cost');
            $table->dateTime('ship_date');
            $table->dateTime('future_ship_date');
            $table->dateTime('delivery_date');
            $table->string('signed_for_by', 55);
            $table->boolean('is_downloads');
            $table->dateTime('last_status_update');
            $table->boolean('saturday_delivery');
            $table->boolean('alcohol');
            $table->boolean('dangerous_goods');
            $table->boolean('dangerous_goods_accessibility');
            $table->boolean('hold_at_location');
            $table->string('hold_at_location_address', 250);
            $table->integer('signature_required');
            $table->boolean('cod');
            $table->decimal('cod_amount', 10);
            $table->integer('cod_currency');
            $table->boolean('insured');
            $table->decimal('insured_value', 10);
            $table->boolean('archived')->index('archived')->comment('0 = active, 1 = archived');
            $table->string('inventory_order_id', 35);
            $table->integer('registry_id');
            $table->index(['order_id', 'ship_method_id'], 'orsh_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_shipments');
    }
};
