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
        Schema::create('wishlists_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('wishlist_id')->index('wishlist_id');
            $table->integer('product_id');
            $table->integer('parent_product');
            $table->dateTime('added');
            $table->integer('parent_wishlists_items_id');
            $table->boolean('is_accessory')->comment('0=no,1=yes,2=as option');
            $table->boolean('accessory_required');
            $table->integer('accessory_field_id');
            $table->boolean('notify_backinstock')->comment('0=no, 1=yes, 2=notified');
            $table->timestamp('notify_backinstock_attempted')->useCurrent();
            $table->unique(['wishlist_id', 'product_id'], 'wlprod_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishlists_items');
    }
};
