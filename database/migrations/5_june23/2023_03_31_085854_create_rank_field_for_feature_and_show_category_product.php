<?php

use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Category\CategoryProductShow;
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
        Schema::table(CategoryProductShow::Table(), function (Blueprint $table) {
            $table->id();
            $table->integer('rank')->default(0)->nullable();
        });
        Schema::table(CategoryFeaturedProduct::Table(), function (Blueprint $table) {
            $table->integer('rank')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
