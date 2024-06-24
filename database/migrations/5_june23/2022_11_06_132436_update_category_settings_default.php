<?php

use Domain\Products\Models\Category\CategorySettings;
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
        Schema::table(CategorySettings::Table(), function (Blueprint $table) {
            $table->boolean('use_default_category')->default(1)->change();
            $table->boolean('use_default_feature')->default(1)->change();
            $table->boolean('use_default_product')->default(1)->change();
            $table->integer('product_thumbnail_template')->nullable()->change();
            $table->integer('category_thumbnail_template')->nullable()->change();
            $table->integer('product_thumbnail_count')->default(0)->change();
            $table->integer('feature_thumbnail_template')->nullable()->change();
            $table->integer('feature_thumbnail_count')->default(0)->change();
            $table->boolean('feature_showsort')->default(0)->change();
            $table->boolean('product_thumbnail_showsort')->default(0)->change();
            $table->boolean('product_thumbnail_showmessage')->default(0)->change();
            $table->boolean('feature_showmessage')->default(0)->change();
            $table->boolean('show_categories_in_body')->default(0)->change();
            $table->boolean('show_products')->default(0)->change();
            $table->boolean('show_featured')->default(0)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
