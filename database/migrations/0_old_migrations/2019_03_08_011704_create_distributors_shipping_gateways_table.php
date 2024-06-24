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
        Schema::create('distributors_shipping_gateways', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('distributor_id');
            $table->integer('shipping_gateway_id');
            $table->index(['distributor_id', 'shipping_gateway_id'], 'dishga_distributor_id');
            $table->unique(['distributor_id', 'shipping_gateway_id'], 'dishga_distship');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_shipping_gateways');
    }
};
