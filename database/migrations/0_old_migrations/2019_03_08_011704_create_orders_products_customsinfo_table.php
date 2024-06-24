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
        Schema::create('orders_products_customsinfo', function (Blueprint $table) {
            $table->integer('orders_products_id')->unique('orprcuin_orders_products_id');
            $table->string('customs_description');
            $table->decimal('customs_weight', 5);
            $table->decimal('customs_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products_customsinfo');
    }
};
