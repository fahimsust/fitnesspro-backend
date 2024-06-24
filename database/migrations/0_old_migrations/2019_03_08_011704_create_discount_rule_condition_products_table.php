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
        Schema::create('discount_rule_condition_products', function (Blueprint $table) {
            $table->integer('condition_id')->index('dirucopro_rule_id');
            $table->integer('product_id')->index('dirucoproproduct_id');
            $table->integer('required_qty');
            $table->unique(['condition_id', 'product_id'], 'dirucoprocondition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition_products');
    }
};
