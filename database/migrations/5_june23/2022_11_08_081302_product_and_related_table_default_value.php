<?php

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\Settings\ProductSettings;
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
        $query = "UPDATE ".Product::Table()." set `default_outofstockstatus_id` = null where default_outofstockstatus_id = 0";
        DB::statement($query);
        Schema::table(Product::Table(), function (Blueprint $table) {
            $table->softDeletes();
            $table->string('subtitle',255)->nullable()->change();
            $table->boolean('status')->default(1)->change();
            $table->string('product_no',155)->nullable()->change();
            $table->decimal('combined_stock_qty')->default(1)->nullable()->change();
            $table->decimal('default_cost', 10, 4)->default(0)->nullable()->change();
            $table->decimal('weight',5)->default(0)->nullable()->change();
            $table->string('meta_title', 155)->nullable()->change();
            $table->string('meta_desc')->nullable()->change();
            $table->string('meta_keywords')->nullable()->change();
            $table->string('inventory_id', 155)->nullable()->change();
            $table->string('customs_description')->nullable()->change();
            $table->string('tariff_number', 55)->nullable()->change();
            $table->string('country_origin', 20)->nullable()->change();
            $table->boolean('has_children')->nullable()->change();
            $table->foreign('default_outofstockstatus_id')
                ->references('id')->on(ProductAvailability::Table());

        });
        Schema::table(ProductDetail::Table(), function (Blueprint $table) {
            $table->decimal('rating',4,1)->default(0)->change();
            $table->integer('views_30days')->default(0)->change();
            $table->integer('views_90days')->default(0)->change();
            $table->integer('views_180days')->default(0)->change();
            $table->integer('views_1year')->default(0)->change();
            $table->integer('views_all')->default(0)->change();
            $table->integer('orders_30days')->default(0)->change();
            $table->integer('orders_90days')->default(0)->change();
            $table->integer('orders_180days')->default(0)->change();
            $table->integer('orders_1year')->default(0)->change();
            $table->integer('orders_all')->default(0)->change();
            $table->boolean('downloadable')->default(0)->change();
            $table->string('downloadable_file', 200)->nullable()->change();
            $table->boolean('create_children_auto')->default(0)->change();
            $table->boolean('display_children_grid')->default(0)->change();
            $table->boolean('override_parent_description')->default(0)->change();
            $table->boolean('allow_pricing_discount')->default(1)->change();
            $table->text('attributes')->nullable()->change();
            $table->renameColumn('attributes', 'product_attributes');
        });
        Schema::table(ProductSettings::Table(), function (Blueprint $table) {
            $table->integer('product_detail_template')->nullable()->change();
            $table->integer('product_thumbnail_template')->nullable()->change();
            $table->integer('product_zoom_template')->nullable()->change();
            $table->integer('product_related_count')->default(0)->change();
            $table->integer('product_brands_count')->default(0)->change();
            $table->integer('product_related_template')->nullable()->change();
            $table->integer('product_brands_template')->nullable()->change();
            $table->boolean('show_brands_products')->default(0)->change();
            $table->boolean('show_related_products')->default(0)->change();
            $table->boolean('show_specs')->default(0)->change();
            $table->boolean('show_reviews')->default(0)->change();
            $table->boolean('use_default_related')->default(1)->change();
            $table->boolean('use_default_brand')->default(1)->change();
            $table->boolean('use_default_specs')->default(1)->change();
            $table->boolean('use_default_reviews')->default(1)->change();
            $table->text('module_custom_values')->nullable()->change();
            $table->text('module_override_values')->nullable()->change();
        });

        Schema::table(ProductPricing::Table(), function (Blueprint $table) {
            $table->decimal('price_reg', 10, 4)->change();
            $table->decimal('price_sale',10,4)->default(null)->nullable()->change();
            $table->boolean('onsale')->default(0)->change();
            $table->integer('min_qty')->default(1)->nullable()->change();
            $table->integer('max_qty')->default(null)->nullable()->change();
            $table->boolean('feature')->default(0)->change();
            $table->boolean('status')->default(1)->change();
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
