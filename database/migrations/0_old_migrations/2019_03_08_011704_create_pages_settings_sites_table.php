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
        Schema::create('pages_settings_sites', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('page_id')->index('pasesi_product_id');
            $table->integer('site_id');
            $table->integer('settings_template_id')->nullable();
            $table->integer('layout_id')->nullable();
            $table->integer('module_template_id')->nullable();
            $table->unique(['page_id', 'site_id'], 'pasesi_product_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_settings_sites');
    }
};
