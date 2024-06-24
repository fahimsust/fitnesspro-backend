<?php

use Domain\Sites\Models\SiteSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $query = "UPDATE ".SiteSettings::Table()." set `cart_allowavailability` = REPLACE(`cart_allowavailability`,'&quot;','')";
        DB::statement($query);
        $query = "UPDATE ".SiteSettings::Table()." set `cart_allowavailability` = '{}' where cart_allowavailability = ''";
        DB::statement($query);
        Schema::table(SiteSettings::Table(), function (Blueprint $table) {
            $table->unsignedBigInteger('default_layout_id')->nullable()->change();
            $table->unsignedBigInteger('search_layout_id')->nullable()->change();
            $table->unsignedBigInteger('home_layout_id')->nullable()->change();
            $table->unsignedBigInteger('default_category_layout_id')->nullable()->change();
            $table->unsignedBigInteger('default_product_layout_id')->nullable()->change();
            $table->unsignedBigInteger('account_layout_id')->nullable()->change();
            $table->unsignedBigInteger('cart_layout_id')->nullable()->change();
            $table->unsignedBigInteger('checkout_layout_id')->nullable()->change();
            $table->unsignedBigInteger('page_layout_id')->nullable()->change();
            $table->unsignedBigInteger('affiliate_layout_id')->nullable()->change();
            $table->unsignedBigInteger('wishlist_layout_id')->nullable()->change();
            $table->unsignedBigInteger('default_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('default_category_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('home_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('default_product_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('account_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('search_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('cart_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('checkout_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('page_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('affiliate_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('wishlist_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('catalog_layout_id')->nullable()->change();
            $table->unsignedBigInteger('catalog_module_template_id')->nullable()->change();
            $table->unsignedBigInteger('offline_layout_id')->nullable()->change();
            $table->integer('default_category_thumbnail_template')->nullable()->change();
            $table->integer('default_product_thumbnail_template')->nullable()->change();
            $table->integer('default_product_detail_template')->nullable()->change();
            $table->integer('default_product_zoom_template')->nullable()->change();
            $table->integer('default_feature_thumbnail_template')->nullable()->change();
            $table->integer('default_feature_count')->nullable()->change();
            $table->integer('default_product_thumbnail_count')->nullable()->change();
            $table->boolean('default_show_categories_in_body')->default(1)->change();
            $table->integer('search_thumbnail_template')->nullable()->change();
            $table->integer('search_thumbnail_count')->nullable()->change();
            $table->integer('home_feature_count')->nullable()->change();
            $table->integer('home_feature_thumbnail_template')->nullable()->change();
            $table->boolean('home_feature_show')->default(1)->change();
            $table->boolean('home_feature_showsort')->default(1)->change();
            $table->boolean('home_feature_showmessage')->default(1)->change();
            $table->boolean('home_show_categories_in_body')->default(1)->change();
            $table->integer('default_product_related_count')->nullable()->change();
            $table->integer('default_product_brands_count')->nullable()->change();
            $table->boolean('default_feature_showsort')->default(1)->change();
            $table->boolean('default_product_thumbnail_showsort')->default(1)->change();
            $table->boolean('default_product_thumbnail_showmessage')->default(1)->change();
            $table->boolean('default_feature_showmessage')->default(1)->change();
            $table->integer('default_product_related_template')->nullable()->change();
            $table->integer('default_product_brands_template')->nullable()->change();
            $table->boolean('require_customer_account')->default(1)->change();
            $table->text('default_module_custom_values')->nullable()->change();
            $table->text('default_category_module_custom_values')->nullable()->change();
            $table->text('default_product_module_custom_values')->nullable()->change();
            $table->text('home_module_custom_values')->nullable()->change();
            $table->text('account_module_custom_values')->nullable()->change();
            $table->text('search_module_custom_values')->nullable()->change();
            $table->text('cart_module_custom_values')->nullable()->change();
            $table->text('checkout_module_custom_values')->nullable()->change();
            $table->text('page_module_custom_values')->nullable()->change();
            $table->text('affiliate_module_custom_values')->nullable()->change();
            $table->text('wishlist_module_custom_values')->nullable()->change();
            $table->text('catalog_module_custom_values')->nullable()->change();
            $table->boolean('catalog_show_products')->default(1)->change();
            $table->boolean('catalog_feature_show')->default(1)->change();
            $table->boolean('catalog_show_categories_in_body')->default(1)->change();
            $table->integer('catalog_feature_count')->nullable()->change();
            $table->integer('catalog_feature_thumbnail_template')->nullable()->change();
            $table->boolean('catalog_feature_showsort')->default(1)->change();
            $table->boolean('catalog_feature_showmessage')->default(1)->change();
            $table->boolean('cart_addtoaction')->comment('0=forward to cart, 1=show popup')->default(1)->change();
            $table->boolean('cart_orderonlyavailableqty')->default(1)->change();
            $table->boolean('checkout_process')->comment('0=5step,1=singlepage')->default(1)->change();
            $table->boolean('filter_categories')->default(1)->change();
            $table->string('recaptcha_key', 55)->nullable()->change();
            $table->string('recaptcha_secret', 55)->nullable()->change();
            $table->json('cart_allowavailability')->nullable(false)->default(null)->change();

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
