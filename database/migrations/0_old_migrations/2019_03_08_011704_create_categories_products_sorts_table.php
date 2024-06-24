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
        Schema::create('categories_products_sorts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('category_id')->index('caprso_category_id');
            $table->integer('sort_id');
            $table->integer('rank');
            $table->boolean('isdefault');
            $table->unique(['category_id', 'sort_id'], 'caprso_category_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_products_sorts');
    }
};
