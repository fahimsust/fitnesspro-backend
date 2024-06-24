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
        Schema::create('products-rules-fulfillment_conditions_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('condition_id')->index('condition_id');
            $table->integer('item_id');
            $table->string('value', 85);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-rules-fulfillment_conditions_items');
    }
};
