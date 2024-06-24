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
        Schema::create('discounts-levels_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('discount_level_id');
            $table->integer('product_id');
            $table->unique(['discount_level_id', 'product_id'], 'discount_level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts-levels_products');
    }
};
