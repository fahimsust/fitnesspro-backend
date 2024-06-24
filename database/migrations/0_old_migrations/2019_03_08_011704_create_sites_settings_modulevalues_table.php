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
        Schema::create('sites_settings_modulevalues', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('section', ['default', 'home', 'search', 'checkout', 'catalog', 'cart', 'product', 'category', 'page', 'wishlist', 'account', 'affiliate']);
            $table->integer('site_id')->index('sisemo_site_id');
            $table->integer('section_id');
            $table->integer('module_id');
            $table->integer('field_id');
            $table->text('custom_value')->nullable();
            $table->index(['section', 'site_id'], 'sisemo_product_id_2');
            $table->unique(['section', 'site_id', 'section_id', 'module_id', 'field_id'], 'sisemo_section');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_settings_modulevalues');
    }
};
