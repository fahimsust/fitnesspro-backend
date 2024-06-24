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
        Schema::create('products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_product')->index('parent_product');
            $table->string('title', 500)->index('title');
            $table->string('subtitle')->index('subtitle');
            $table->integer('default_outofstockstatus_id')->nullable();
            $table->integer('details_img_id');
            $table->integer('category_img_id')->index('category_img_id');
            $table->boolean('status')->index('prods_status');
            $table->string('product_no', 155)->index('product_no');
            $table->decimal('combined_stock_qty')->index('combined_stock_qty');
            $table->decimal('default_cost', 10, 4)->nullable();
            $table->decimal('weight', 5);
            $table->dateTime('created');
            $table->integer('default_distributor_id')->nullable();
            $table->integer('fulfillment_rule_id')->nullable()->index('fulfillment_rule_id');
            $table->string('url_name')->unique('url_name');
            $table->string('meta_title', 155);
            $table->string('meta_desc');
            $table->string('meta_keywords')->index('meta_keywords');
            $table->string('inventory_id', 155)->index('inventory_id');
            $table->string('customs_description');
            $table->string('tariff_number', 55);
            $table->string('country_origin', 20);
            $table->boolean('inventoried')->default(1);
            $table->string('shared_inventory_id', 155)->nullable()->index('shared_inv');
            $table->enum('addtocart_setting', ['0', '1', '2'])->nullable()->default('0');
            $table->string('addtocart_external_label')->nullable();
            $table->string('addtocart_external_link')->nullable();
            $table->boolean('has_children')->index('has_children');
//            $table->index(['url_name', 'title', 'product_no', 'subtitle'], 'titleurlnosubtitle');
            $table->index(['url_name', 'title'], 'titleurl');
            $table->index(['status', 'parent_product', 'has_children', 'inventoried', 'id', 'default_outofstockstatus_id'], 'products_index_1');
            $table->index(['parent_product', 'status'], 'parent_product_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
