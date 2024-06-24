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
        Schema::create('giftregistry_items_purchased', function (Blueprint $table) {
            $table->integer('registry_item_id')->index('registry_id');
            $table->integer('account_id');
            $table->decimal('qty_purchased');
            $table->integer('order_id');
            $table->integer('order_product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giftregistry_items_purchased');
    }
};
