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
        Schema::create('products_settings_sites_modulevalues', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('product_id')->index('prsesimo_product_id');
            $table->integer('site_id');
            $table->integer('section_id');
            $table->integer('module_id');
            $table->integer('field_id');
            $table->text('custom_value')->nullable();
            $table->index(['product_id', 'site_id'], 'prsesimo_product_id_2');
            $table->unique(['product_id', 'site_id', 'section_id', 'module_id', 'field_id'], 'prsesimo_product_id_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_settings_sites_modulevalues');
    }
};
