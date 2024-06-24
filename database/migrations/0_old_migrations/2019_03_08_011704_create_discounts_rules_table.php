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
        Schema::create('discounts_rules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('discount_id')->index('dirules_discount_id');
            $table->integer('rule_type_id');
            $table->decimal('required_cart_value', 10);
            $table->integer('required_product_qty');
            $table->string('required_code', 25);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts_rules');
    }
};
