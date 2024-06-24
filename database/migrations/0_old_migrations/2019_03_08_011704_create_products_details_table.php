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
        Schema::create('products_details', function (Blueprint $table) {
            $table->integer('product_id')->primary();
            $table->text('summary');
            $table->text('description'); //->index('description');
            $table->text('attributes');
            $table->integer('type_id');
            $table->integer('brand_id')->index('brand_id');
            $table->decimal('rating', 4, 1);
            $table->integer('views_30days');
            $table->integer('views_90days');
            $table->integer('views_180days');
            $table->integer('views_1year');
            $table->integer('views_all');
            $table->integer('orders_30days');
            $table->integer('orders_90days');
            $table->integer('orders_180days');
            $table->integer('orders_1year');
            $table->integer('orders_all');
            $table->boolean('downloadable');
            $table->string('downloadable_file', 200);
            $table->integer('default_category_id');
            $table->dateTime('orders_updated');
            $table->dateTime('views_updated');
            $table->boolean('create_children_auto');
            $table->boolean('display_children_grid');
            $table->boolean('override_parent_description');
            $table->boolean('allow_pricing_discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_details');
    }
};
