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
        Schema::create('categories_settings', function (Blueprint $table) {
            $table->integer('category_id')->primary();
            $table->integer('settings_template_id');
            $table->boolean('use_default_category');
            $table->boolean('use_default_feature');
            $table->boolean('use_default_product');
            $table->integer('category_thumbnail_template');
            $table->integer('product_thumbnail_template');
            $table->integer('product_thumbnail_count');
            $table->integer('feature_thumbnail_template');
            $table->integer('feature_thumbnail_count');
            $table->boolean('feature_showsort');
            $table->boolean('product_thumbnail_showsort');
            $table->boolean('product_thumbnail_showmessage');
            $table->boolean('feature_showmessage');
            $table->boolean('show_categories_in_body');
            $table->boolean('show_products');
            $table->boolean('show_featured');
            $table->integer('layout_id');
            $table->integer('module_template_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_settings');
    }
};
