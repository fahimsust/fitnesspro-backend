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
        Schema::create('sites_settings', function (Blueprint $table) {
            $table->integer('site_id')->primary();
            $table->integer('default_layout_id');
            $table->integer('default_category_thumbnail_template');
            $table->integer('default_product_thumbnail_template');
            $table->integer('default_product_detail_template');
            $table->integer('default_product_zoom_template');
            $table->integer('default_feature_thumbnail_template');
            $table->integer('default_feature_count');
            $table->integer('default_product_thumbnail_count');
            $table->boolean('default_show_categories_in_body');
            $table->integer('search_layout_id');
            $table->integer('search_thumbnail_template');
            $table->integer('search_thumbnail_count');
            $table->integer('home_feature_count');
            $table->integer('home_feature_thumbnail_template');
            $table->boolean('home_feature_show');
            $table->boolean('home_feature_showsort');
            $table->boolean('home_feature_showmessage');
            $table->boolean('home_show_categories_in_body');
            $table->integer('home_layout_id');
            $table->integer('default_product_related_count');
            $table->integer('default_product_brands_count');
            $table->boolean('default_feature_showsort');
            $table->boolean('default_product_thumbnail_showsort');
            $table->boolean('default_product_thumbnail_showmessage');
            $table->boolean('default_feature_showmessage');
            $table->integer('default_product_related_template');
            $table->integer('default_product_brands_template');
            $table->boolean('require_customer_account');
            $table->integer('default_category_layout_id');
            $table->integer('default_product_layout_id');
            $table->integer('account_layout_id');
            $table->integer('cart_layout_id');
            $table->integer('checkout_layout_id');
            $table->integer('page_layout_id');
            $table->integer('affiliate_layout_id');
            $table->integer('wishlist_layout_id');
            $table->integer('default_module_template_id');
            $table->text('default_module_custom_values');
            $table->integer('default_category_module_template_id');
            $table->text('default_category_module_custom_values');
            $table->integer('default_product_module_template_id');
            $table->text('default_product_module_custom_values');
            $table->integer('home_module_template_id');
            $table->text('home_module_custom_values');
            $table->integer('account_module_template_id');
            $table->text('account_module_custom_values');
            $table->integer('search_module_template_id');
            $table->text('search_module_custom_values');
            $table->integer('cart_module_template_id');
            $table->text('cart_module_custom_values');
            $table->integer('checkout_module_template_id');
            $table->text('checkout_module_custom_values');
            $table->integer('page_module_template_id');
            $table->text('page_module_custom_values');
            $table->integer('affiliate_module_template_id');
            $table->text('affiliate_module_custom_values');
            $table->integer('wishlist_module_template_id');
            $table->text('wishlist_module_custom_values');
            $table->integer('catalog_layout_id');
            $table->integer('catalog_module_template_id');
            $table->text('catalog_module_custom_values');
            $table->boolean('catalog_show_products');
            $table->boolean('catalog_feature_show');
            $table->boolean('catalog_show_categories_in_body');
            $table->integer('catalog_feature_count');
            $table->integer('catalog_feature_thumbnail_template');
            $table->boolean('catalog_feature_showsort');
            $table->boolean('catalog_feature_showmessage');
            $table->boolean('cart_addtoaction')->comment('0=forward to cart, 1=show popup');
            $table->boolean('cart_orderonlyavailableqty');
            $table->boolean('checkout_process')->comment('0=5step,1=singlepage');
            $table->integer('offline_layout_id');
            $table->string('cart_allowavailability', 100)->default('any')->comment('any, instock, lowstock, outofstock, onorder, discontinued');
            $table->boolean('filter_categories');
            $table->integer('default_category_search_form_id');
            $table->string('recaptcha_key', 55);
            $table->string('recaptcha_secret', 55);
            $table->index(['site_id', 'default_product_thumbnail_template'], 'sites_settings_index_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_settings');
    }
};
