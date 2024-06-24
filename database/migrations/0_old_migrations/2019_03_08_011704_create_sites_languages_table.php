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
        Schema::create('sites_languages', function (Blueprint $table) {
            $table->integer('site_id');
            $table->integer('language_id');
            $table->tinyInteger('rank');
            $table->unique(['site_id', 'language_id'], 'sitelang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_languages');
    }
};