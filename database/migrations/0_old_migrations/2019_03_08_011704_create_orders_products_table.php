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
        Schema::create('orders_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id')->index('orpr_order_id_2');
            $table->integer('product_id')->index('orpr_product_id');
            $table->integer('product_qty');
            $table->decimal('product_price');
            $table->string('product_notes');
            $table->decimal('product_saleprice');
            $table->boolean('product_onsale');
            $table->integer('actual_product_id')->index('orpr_actual_product_id');
            $table->integer('package_id')->index('orpr_package_id');
            $table->integer('parent_product_id')->comment('If accessory showing as option, id of product that this should show under');
            $table->integer('cart_id')->comment('unique id in cart');
            $table->string('product_label', 155);
            $table->integer('registry_item_id');
            $table->integer('free_from_discount_advantage');
            $table->index(['order_id', 'product_id', 'package_id'], 'orpr_order_id');
            $table->index(['order_id', 'product_id', 'actual_product_id'], 'orpr_order_id_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products');
    }
};
