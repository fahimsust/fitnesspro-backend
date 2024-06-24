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
        Schema::create('products_settings_templates', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->integer('settings_template_id')->nullable();
            $table->integer('product_detail_template')->nullable();
            $table->integer('product_thumbnail_template')->nullable();
            $table->integer('product_zoom_template')->nullable();
            $table->integer('layout_id')->nullable();
            $table->integer('module_template_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_settings_templates');
    }
};
