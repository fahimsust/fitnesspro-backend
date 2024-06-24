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
        Schema::create('discount_rule_condition_outofstockstatuses', function (Blueprint $table) {
            $table->integer('condition_id')->index('dirucoou_rule_id');
            $table->integer('outofstockstatus_id')->index('dirucoou_product_id');
            $table->integer('required_qty');
            $table->unique(['condition_id', 'outofstockstatus_id'], 'dirucoou_condition_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_condition_outofstockstatuses');
    }
};
