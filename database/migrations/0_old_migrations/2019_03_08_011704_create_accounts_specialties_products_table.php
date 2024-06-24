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
        Schema::create('accounts-specialties_products', function (Blueprint $table) {
            $table->integer('specialty_id')->index('aspecp_type_id_2');
            $table->integer('product_id')->index('aspecp_product_id');
            $table->unique(['specialty_id', 'product_id'], 'aspecp_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts-specialties_products');
    }
};
