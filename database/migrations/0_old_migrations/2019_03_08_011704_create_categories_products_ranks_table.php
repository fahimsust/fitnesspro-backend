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
        Schema::create('categories_products_ranks', function (Blueprint $table) {
            $table->integer('category_id')->index('caprra_category_id');
            $table->integer('product_id');
            $table->integer('rank');
            $table->index(['category_id', 'product_id'], 'caprra_categories_products_ranks_index_1');
            $table->unique(['category_id', 'product_id'], 'caprra_catproductmanual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_products_ranks');
    }
};
