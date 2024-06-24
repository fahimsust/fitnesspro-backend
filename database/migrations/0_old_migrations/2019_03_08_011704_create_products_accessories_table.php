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
        Schema::create('products_accessories', function (Blueprint $table) {
            $table->integer('product_id')->index('prac_product_id');
            $table->integer('accessory_id');
            $table->boolean('required');
            $table->boolean('show_as_option');
            $table->tinyInteger('discount_percentage');
            $table->string('description');
            $table->boolean('link_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_accessories');
    }
};
