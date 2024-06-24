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
        Schema::create('categories_settings_sites', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id');
            $table->integer('site_id');
            $table->integer('settings_template_id')->nullable();
            $table->integer('category_thumbnail_template')->nullable();
            $table->integer('product_thumbnail_template')->nullable();
            $table->integer('product_thumbnail_count')->nullable();
            $table->integer('feature_thumbnail_template')->nullable();
            $table->integer('feature_thumbnail_count')->nullable();
            $table->boolean('feature_showsort')->nullable();
            $table->tinyInteger('feature_defaultsort')->nullable();
            $table->boolean('product_thumbnail_showsort')->nullable();
            $table->tinyInteger('product_thumbnail_defaultsort')->nullable();
            $table->boolean('product_thumbnail_customsort')->nullable();
            $table->boolean('product_thumbnail_showmessage')->nullable();
            $table->boolean('feature_showmessage')->nullable();
            $table->boolean('show_categories_in_body')->nullable();
            $table->boolean('show_products')->nullable();
            $table->boolean('show_featured')->nullable();
            $table->integer('layout_id')->nullable();
            $table->integer('module_template_id')->nullable();
            $table->integer('search_form_id')->nullable();
            $table->unique(['category_id', 'site_id'], 'casesi_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_settings_sites');
    }
};
