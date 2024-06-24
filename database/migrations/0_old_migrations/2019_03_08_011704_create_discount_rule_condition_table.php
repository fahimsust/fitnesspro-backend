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
        Schema::create('discount_rule_condition', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rule_id');
            $table->integer('condition_type_id');
            $table->decimal('required_cart_value', 10);
            $table->string('required_code', 25);
            $table->boolean('required_qty_type');
            $table->integer('required_qty_combined')->default(1);
            $table->boolean('match_anyall');
            $table->integer('rank')->default(1);
            $table->boolean('equals_notequals');
            $table->boolean('use_with_rules_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition');
    }
};
