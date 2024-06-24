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
        Schema::create('products-children_options', function (Blueprint $table) {
            $table->integer('product_id')->index('prchop_product_id');
            $table->integer('option_id')->index('prchop_option_id');
            $table->unique(['product_id', 'option_id'], 'prchop_product_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products-children_options');
    }
};
