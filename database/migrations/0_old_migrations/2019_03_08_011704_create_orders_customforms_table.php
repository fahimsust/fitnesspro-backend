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
        Schema::create('orders_customforms', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id')->index('orcu_order_id');
            $table->integer('form_id');
            $table->integer('product_id');
            $table->integer('product_type_id');
            $table->integer('form_count');
            $table->text('form_values');
            $table->dateTime('created');
            $table->dateTime('modified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_customforms');
    }
};
