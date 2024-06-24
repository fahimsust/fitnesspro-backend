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
        Schema::create('filters_categories', function (Blueprint $table) {
            $table->integer('filter_id')->index('ficat_filter_id_2');
            $table->integer('category_id')->index('ficat_category_id');
            $table->unique(['filter_id', 'category_id'], 'ficat_filter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters_categories');
    }
};
