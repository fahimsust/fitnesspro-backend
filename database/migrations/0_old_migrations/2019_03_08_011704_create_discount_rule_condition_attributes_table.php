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
        Schema::create('discount_rule_condition_attributes', function (Blueprint $table) {
            $table->integer('condition_id')->index('dirucoat_rule_id');
            $table->integer('attributevalue_id')->index('dirucoat_product_id');
            $table->integer('required_qty')->default(1);
            $table->unique(['condition_id', 'attributevalue_id'], 'dirucoat_condition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition_attributes');
    }
};
