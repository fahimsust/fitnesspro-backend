<?php

use Domain\Products\Models\Category\Category;
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
        Schema::table(Category::Table(), function (Blueprint $table) {
            $table->string('subtitle',255)->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->unsignedBigInteger('image_id')->nullable()->change();
            $table->integer('rank')->default(1)->change();
            $table->boolean('status')->default(1)->change();
            $table->boolean('show_sale')->default(0)->change();
            $table->boolean('limit_min_price')->default(0)->change();
            $table->decimal('min_price', 10)->default(null)->nullable()->change();
            $table->boolean('limit_max_price')->default(0)->change();
            $table->decimal('max_price', 10)->default(null)->nullable()->change();
            $table->integer('limit_days')->default(null)->nullable()->change();
            $table->string('meta_title',200)->nullable()->change();
            $table->string('meta_desc',255)->nullable()->change();
            $table->string('meta_keywords',255)->nullable()->change();
            $table->boolean('rules_match_type')->comment('0=any, 1=all')->default(0)->change();
            $table->string('inventory_id',35)->nullable()->change();
            $table->string('menu_class',55)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
