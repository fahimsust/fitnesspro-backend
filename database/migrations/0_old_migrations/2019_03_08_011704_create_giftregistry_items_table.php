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
        Schema::create('giftregistry_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('registry_id')->index('giit_registry_id');
            $table->integer('product_id');
            $table->integer('parent_product');
            $table->dateTime('added');
            $table->decimal('qty_wanted');
            $table->decimal('qty_purchased');
            $table->boolean('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giftregistry_items');
    }
};
