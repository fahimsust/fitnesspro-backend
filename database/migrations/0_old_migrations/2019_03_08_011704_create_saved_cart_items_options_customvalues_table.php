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
        Schema::create('saved_cart_items_options_customvalues', function (Blueprint $table) {
            $table->integer('saved_cart_item_id');
            $table->integer('option_id');
            $table->text('custom_value');
            $table->unique(['saved_cart_item_id', 'option_id'], 'cartitem_option');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_cart_items_options_customvalues');
    }
};
