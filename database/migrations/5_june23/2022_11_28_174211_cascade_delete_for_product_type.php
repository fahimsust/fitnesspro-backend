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
        Schema::table('categories_types', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->foreign('type_id')
                ->references('id')->on('products_types')->onDelete('cascade');
        });
        Schema::table('custom_forms_show_producttypes', function (Blueprint $table) {
            $table->dropForeign(['product_type_id']);
            $table->foreign('product_type_id')
                ->references('id')->on('products_types')->onDelete('cascade');
        });
        Schema::table('discount_advantage_producttypes', function (Blueprint $table) {
            $table->dropForeign(['producttype_id']);
            $table->foreign('producttype_id')
                ->references('id')->on('products_types')->onDelete('cascade');
        });
        Schema::table('discount_rule_condition_producttypes', function (Blueprint $table) {
            $table->dropForeign('ptype_id');
            $table->foreign('producttype_id', 'ptype_id')
                ->references('id')->on('products_types')->onDelete('cascade');
        });
        Schema::table('orders_customforms', function (Blueprint $table) {
            $table->dropForeign(['product_type_id']);
            $table->foreign('product_type_id')
                ->references('id')->on('products_types')->onDelete('set null');
        });
        Schema::table('products_types_attributes_sets', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->foreign('type_id')
                ->references('id')->on('products_types')->onDelete('cascade');

        });
        Schema::table('tax_rules_product_types', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->foreign('type_id')
                ->references('id')->on('products_types')->onDelete('cascade');
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
