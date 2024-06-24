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
        Schema::create('pages_settings_sites_modulevalues', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('page_id')->index('pasesimo_product_id');
            $table->integer('site_id');
            $table->integer('section_id');
            $table->integer('module_id');
            $table->integer('field_id');
            $table->text('custom_value')->nullable();
            $table->index(['page_id', 'site_id'], 'pasesimo_product_id_2');
            $table->unique(['page_id', 'site_id', 'section_id', 'module_id', 'field_id'], 'pasesimo_product_id_3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_settings_sites_modulevalues');
    }
};
