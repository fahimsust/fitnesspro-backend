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
        Schema::create('discounts_rules_products', function (Blueprint $table) {
            $table->integer('rule_id')->index('diruprod_rule_id');
            $table->integer('product_id');
            $table->unique(['rule_id', 'product_id'], 'diruprod_rule_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts_rules_products');
    }
};
