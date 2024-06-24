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
        Schema::create('sites_categories', function (Blueprint $table) {
            $table->integer('site_id')->index('sica_site_id');
            $table->integer('category_id')->index('sica_category_id');
            $table->unique(['site_id', 'category_id'], 'sica_site_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_categories');
    }
};
