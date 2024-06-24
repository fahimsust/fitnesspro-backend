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
        Schema::create('products_options', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->string('display', 100);
            $table->integer('type_id');
            $table->boolean('show_with_thumbnail');
            $table->integer('rank');
            $table->boolean('required')->default(1);
            $table->integer('product_id')->index('prop_product_id');
            $table->boolean('is_template');
            $table->boolean('status')->default(1);
            $table->unique(['name', 'type_id', 'product_id', 'status'], 'prop_nametypeidstatus');
            $table->index(['status', 'product_id'], 'prop_products_options_index_1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_options');
    }
};
