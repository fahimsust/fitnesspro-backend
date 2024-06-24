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
        Schema::create('wishlists_items_options_customvalues', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('wishlists_item_id');
            $table->integer('option_id');
            $table->text('custom_value');
            $table->unique(['wishlists_item_id', 'option_id'], 'wiitopcu_cartitem_option');
            $table->unique(['wishlists_item_id', 'option_id'], 'wiitopcu_saved_cart_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlists_items_options_customvalues');
    }
};
