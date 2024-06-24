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
        Schema::create('products-rules-fulfillment_conditions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('rule_id')->index('prrufuco_rule_id');
            $table->enum('type', ['has_stock', 'logged_in', 'account_type', 'shipping_country', 'shipping_state', 'shipping_zipcode', 'stock_greaterthan_qtyordering', 'has_most_stock'])->index('prrufuco_type');
            $table->boolean('status')->index('prrufuco_status');
            $table->enum('any_all', ['all', 'any']);
            $table->integer('target_distributor');
            $table->integer('score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-rules-fulfillment_conditions');
    }
};
