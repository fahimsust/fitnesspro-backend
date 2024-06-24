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
        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent_id')->index('cats_parent_id');
            $table->string('title');
            $table->string('subtitle');
            $table->text('description');
            $table->integer('image_id');
            $table->integer('rank');
            $table->boolean('status');
            $table->string('url_name', 155);
            $table->boolean('show_sale');
            $table->boolean('limit_min_price');
            $table->decimal('min_price', 10);
            $table->boolean('limit_max_price');
            $table->decimal('max_price', 10);
            $table->boolean('show_in_list')->default(1);
            $table->integer('limit_days');
            $table->string('meta_title', 200);
            $table->string('meta_desc');
            $table->string('meta_keywords');
            $table->boolean('show_types')->default(1);
            $table->boolean('show_brands')->default(1);
            $table->boolean('rules_match_type')->comment('0=any, 1=all');
            $table->string('inventory_id', 35)->index('cats_inventory_id');
            $table->string('menu_class', 55);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
