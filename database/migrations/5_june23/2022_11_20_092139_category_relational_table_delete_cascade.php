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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->foreign('parent_id')
              ->references('id')->on('categories')->onDelete('cascade');
        });
//        Schema::table('categories_attributes', function (Blueprint $table) {
//            $table->dropForeign(['category_id']);
//            $table->foreign('category_id')
//                ->references('id')->on('categories')->onDelete('cascade');
//        });
//        Schema::table('categories_attributes_rules', function (Blueprint $table) {
//            $table->dropForeign(['category_id']);
//            $table->foreign('category_id')
//                ->references('id')->on('categories')->onDelete('cascade');
//        });
        Schema::table('categories_brands', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_featured', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_products_assn', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_products_hide', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_products_ranks', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_products_sorts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
              ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_rules', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
              ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_settings', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_settings_sites', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_settings_sites_modulevalues', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('categories_types', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('filters_categories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('menus_catalogcategories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('menus_categories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
        Schema::table('sites_categories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
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
