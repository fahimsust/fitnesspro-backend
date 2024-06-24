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
        Schema::create('accounts-types_products', function (Blueprint $table) {
            $table->integer('type_id')->index('atypep_type_id_2');
            $table->integer('product_id')->index('atypep_product_id');
            $table->unique(['type_id', 'product_id'], 'atypep_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-types_products');
    }
};
