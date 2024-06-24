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
        Schema::create('accessories_fields_products', function (Blueprint $table) {
            $table->integer('accessories_fields_id')->index('accessories_fields_id');
            $table->integer('product_id')->index('product_id');
            $table->string('label', 100);
            $table->integer('rank');
            $table->boolean('price_adjust_type')->comment('1=adjust this price, 2=adjust parent price');
            $table->boolean('price_adjust_calc')->comment('1=flat amount, 2=percentage');
            $table->decimal('price_adjust_amount');
            $table->unique(['accessories_fields_id', 'product_id'], 'accessories_fields_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessories_fields_products');
    }
};
