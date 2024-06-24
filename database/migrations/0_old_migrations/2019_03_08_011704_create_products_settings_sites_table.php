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
        Schema::create('products_settings_sites', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('product_id')->index('prsesi_product_id');
            $table->integer('site_id')->index('prsesi_site_id');
            $table->integer('settings_template_id')->nullable();
            $table->integer('product_detail_template')->nullable();
            $table->integer('product_thumbnail_template')->nullable();
            $table->integer('product_zoom_template')->nullable();
            $table->integer('layout_id')->nullable();
            $table->integer('module_template_id')->nullable();
            $table->unique(['product_id', 'site_id'], 'prsesi_product_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_settings_sites');
    }
};
