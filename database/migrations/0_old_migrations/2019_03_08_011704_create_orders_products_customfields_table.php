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
        Schema::create('orders_products_customfields', function (Blueprint $table) {
            $table->integer('orders_products_id')->index('orprcu_orders_products_id');
            $table->integer('form_id');
            $table->integer('section_id');
            $table->integer('field_id');
            $table->text('value');
            $table->unique(['orders_products_id', 'form_id', 'section_id', 'field_id'], 'orprcu_orders_products_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products_customfields');
    }
};
