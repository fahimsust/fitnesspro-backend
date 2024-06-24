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
        Schema::create('categories_featured', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id')->index('cafe_category_id');
            $table->integer('product_id')->index('cafe_product_id');
            $table->unique(['category_id', 'product_id'], 'cafe_category_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_featured');
    }
};
