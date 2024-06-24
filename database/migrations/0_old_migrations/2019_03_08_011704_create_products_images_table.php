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
        Schema::create('products_images', function (Blueprint $table) {
            $table->integer('product_id')->index('prim_product_id');
            $table->integer('image_id')->index('prim_image_id');
            $table->string('caption', 55);
            $table->tinyInteger('rank');
            $table->boolean('show_in_gallery')->default(1);
            $table->unique(['product_id', 'image_id'], 'prim_prodimage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_images');
    }
};
