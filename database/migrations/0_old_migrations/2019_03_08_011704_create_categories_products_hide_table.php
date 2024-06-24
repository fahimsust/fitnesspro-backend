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
        Schema::create('categories_products_hide', function (Blueprint $table) {
            $table->integer('category_id')->index('caprhi_category_id');
            $table->integer('product_id');
            $table->index(['product_id', 'category_id'], 'caprhi_categories_products_hide_index_1');
            $table->unique(['category_id', 'product_id'], 'caprhi_catproduct');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_products_hide');
    }
};
