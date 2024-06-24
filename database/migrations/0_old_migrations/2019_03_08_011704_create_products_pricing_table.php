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
        Schema::create('products_pricing', function (Blueprint $table) {
            $table->integer('product_id');
            $table->integer('site_id');
            $table->decimal('price_reg', 10, 4);
            $table->decimal('price_sale', 10, 4);
            $table->boolean('onsale');
            $table->decimal('min_qty')->default(1.00);
            $table->decimal('max_qty')->default(0.00);
            $table->boolean('feature');
            $table->integer('pricing_rule_id');
            $table->integer('ordering_rule_id');
            $table->boolean('status')->index('status');
            $table->dateTime('published_date');
            $table->unique(['product_id', 'site_id'], 'prodsite');
            $table->index(['status', 'site_id', 'product_id', 'ordering_rule_id'], 'products_pricing_index_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_pricing');
    }
};
