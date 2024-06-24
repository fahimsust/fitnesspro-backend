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
        Schema::create('saved_cart_discounts', function (Blueprint $table) {
            $table->integer('saved_cart_id')->primary();
            $table->longText('applied_codes_json');
            $table->longText('shipping_discounts_json');
            $table->longText('order_discounts_json');
            $table->longText('product_discounts_json');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_cart_discounts');
    }
};
