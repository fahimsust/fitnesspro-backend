<?php

use Domain\Products\Models\Product\Settings\ProductSettingsTemplate;
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
        Schema::table(ProductSettingsTemplate::Table(), function (Blueprint $table) {
            $table->integer('layout_id_default')->nullable();
            $table->integer('module_template_id_default')->nullable();
            $table->integer('product_detail_template_default')->nullable();
            $table->integer('product_thumbnail_template_default')->nullable();
            $table->integer('product_zoom_template_default')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_field_product_setting_template');
    }
};
