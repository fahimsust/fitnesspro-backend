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
        Schema::create('saved_cart_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('saved_cart_id')->index('saved_cart_id');
            $table->integer('cart_id')->comment('cartitem_id to signify row');
            $table->integer('product_id');
            $table->integer('parent_product');
            $table->integer('parent_cart_id');
            $table->integer('required');
            $table->integer('qty');
            $table->decimal('price_reg');
            $table->decimal('price_sale');
            $table->boolean('onsale');
            $table->string('product_label', 155);
            $table->integer('registry_item_id');
            $table->integer('accessory_field_id');
            $table->integer('distributor_id');
            $table->integer('accessory_link_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_cart_items');
    }
};
