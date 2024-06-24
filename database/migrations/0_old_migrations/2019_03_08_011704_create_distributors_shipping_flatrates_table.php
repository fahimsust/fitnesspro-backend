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
        Schema::create('distributors_shipping_flatrates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('distributor_shippingmethod_id')->index('distributor_id');
            $table->decimal('start_weight');
            $table->decimal('end_weight');
            $table->integer('shipto_country');
            $table->boolean('status');
            $table->decimal('flat_price');
            $table->decimal('handling_fee');
            $table->boolean('call_for_estimate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_shipping_flatrates');
    }
};
