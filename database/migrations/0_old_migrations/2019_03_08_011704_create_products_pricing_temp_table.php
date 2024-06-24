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
        Schema::create('products_pricing_temp', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('site_id');
            $table->decimal('price_reg');
            $table->decimal('price_sale');
            $table->boolean('onsale');
            $table->integer('min_qty')->default(1);
            $table->integer('max_qty')->default(0);
            $table->boolean('feature');
            $table->integer('pricing_rule_id');
            $table->integer('ordering_rule_id');
            $table->boolean('status');
            $table->index(['product_id', 'site_id'], 'prprte_product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_pricing_temp');
    }
};
