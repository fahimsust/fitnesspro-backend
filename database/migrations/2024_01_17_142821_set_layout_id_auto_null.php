<?php

use Domain\Content\Models\Pages\PageSetting;
use Domain\Content\Models\Pages\PageSettingsTemplate;
use Domain\Products\Models\Category\CategorySettings;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Domain\Products\Models\Product\Settings\ProductSiteSettings;
use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(CategorySettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table(CategorySiteSettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table(CategorySettingsTemplate::Table(), function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table(PageSetting::Table(), function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table("pages_settings_sites", function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table(PageSettingsTemplate::Table(), function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table(ProductSettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table(ProductSettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table(ProductSiteSettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['layout_id']);
            $table->foreign('layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
        Schema::table(SiteSettings::Table(), function (Blueprint $table) {
            $table->dropForeign(['default_layout_id']);
            $table->dropForeign(['search_layout_id']);
            $table->dropForeign(['home_layout_id']);
            $table->dropForeign(['default_category_layout_id']);
            $table->dropForeign(['default_product_layout_id']);
            $table->dropForeign(['account_layout_id']);
            $table->dropForeign(['cart_layout_id']);
            $table->dropForeign(['checkout_layout_id']);
            $table->dropForeign(['page_layout_id']);
            $table->dropForeign(['affiliate_layout_id']);
            $table->dropForeign(['wishlist_layout_id']);
            $table->dropForeign(['catalog_layout_id']);
            $table->dropForeign(['offline_layout_id']);
            $table->foreign('default_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('search_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('home_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('default_category_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('default_product_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('account_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('cart_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('checkout_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('page_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('affiliate_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('wishlist_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('catalog_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
            $table->foreign('offline_layout_id')
                ->references('id')->on('display_layouts')-> nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
