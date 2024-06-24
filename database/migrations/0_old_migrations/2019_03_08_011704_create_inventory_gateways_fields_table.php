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
        Schema::create('inventory_gateways_fields', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('gateway_id')->index('gateway_id');
            $table->string('feed_field', 100);
            $table->string('product_field', 100);
            $table->boolean('displayorvalue')->comment('display or value of product field: 0=display, 1=value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_gateways_fields');
    }
};
