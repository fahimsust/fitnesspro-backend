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
        Schema::create('products_settings', function (Blueprint $table) {
            $table->integer('product_id')->primary();
            $table->integer('settings_template_id');
            $table->integer('product_detail_template');
            $table->integer('product_thumbnail_template');
            $table->integer('product_zoom_template');
            $table->integer('product_related_count');
            $table->integer('product_brands_count');
            $table->integer('product_related_template');
            $table->integer('product_brands_template');
            $table->boolean('show_brands_products');
            $table->boolean('show_related_products');
            $table->boolean('show_specs');
            $table->boolean('show_reviews');
            $table->integer('layout_id');
            $table->integer('module_template_id');
            $table->text('module_custom_values');
            $table->text('module_override_values');
            $table->boolean('use_default_related');
            $table->boolean('use_default_brand');
            $table->boolean('use_default_specs');
            $table->boolean('use_default_reviews');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_settings');
    }
};
