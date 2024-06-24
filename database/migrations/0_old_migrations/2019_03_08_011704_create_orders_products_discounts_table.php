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
        Schema::create('orders_products_discounts', function (Blueprint $table) {
            $table->integer('orders_products_id')->index('orprdi_orders_products_id');
            $table->integer('discount_id');
            $table->integer('advantage_id');
            $table->string('amount', 12);
            $table->integer('qty');
            $table->integer('id', true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products_discounts');
    }
};
