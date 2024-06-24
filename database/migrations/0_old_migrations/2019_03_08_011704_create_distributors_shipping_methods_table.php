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
        Schema::create('distributors_shipping_methods', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('distributor_id');
            $table->integer('shipping_method_id');
            $table->boolean('status');
            $table->decimal('flat_price');
            $table->boolean('flat_use');
            $table->decimal('handling_fee');
            $table->decimal('handling_percentage');
            $table->boolean('call_for_estimate');
            $table->decimal('discount_rate');
            $table->string('display')->nullable();
            $table->boolean('override_is_international')->nullable();
            $table->index(['distributor_id', 'shipping_method_id'], 'dishme_distributor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distributors_shipping_methods');
    }
};
