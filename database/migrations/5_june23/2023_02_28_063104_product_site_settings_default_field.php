<?php

use Domain\Products\Models\Product\Settings\ProductSiteSettings;
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
        Schema::table(ProductSiteSettings::Table(), function (Blueprint $table) {
            $table->integer('settings_template_id_default')->nullable();
            $table->integer('layout_id_default')->nullable();
            $table->integer('module_template_id_default')->nullable();
            $table->integer('product_detail_template_default')->nullable();
            $table->integer('product_thumbnail_template_default')->nullable();
            $table->integer('product_zoom_template_default')->nullable();
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
