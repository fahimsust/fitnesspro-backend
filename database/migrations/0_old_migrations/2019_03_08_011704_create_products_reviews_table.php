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
        Schema::create('products_reviews', function (Blueprint $table) {
            $table->integer('id', true);
            $table->boolean('item_type');
            $table->integer('item_id')->index('prrev_product_id')->comment('product or attribute id');
            $table->string('name', 85);
            $table->text('comment');
            $table->dateTime('created');
            $table->decimal('rating', 2, 1);
            $table->boolean('approved');
            $table->index(['item_type', 'item_id'], 'prrev_item_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_reviews');
    }
};
