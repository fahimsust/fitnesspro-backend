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
        Schema::create('discount_rule_condition_productavailabilities', function (Blueprint $table) {
            $table->integer('condition_id')->index('dirucopr_rule_id');
            $table->integer('availability_id')->index('dirucopr_product_id');
            $table->integer('required_qty');
            $table->unique(['condition_id', 'availability_id'], 'dirucopr_condition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition_productavailabilities');
    }
};
