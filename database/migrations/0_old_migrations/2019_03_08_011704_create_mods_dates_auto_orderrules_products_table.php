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
        Schema::create('mods_dates_auto_orderrules_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('dao_id');
            $table->integer('product_id');
            $table->unique(['product_id', 'dao_id'], 'mdaop_product_dao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mods_dates_auto_orderrules_products');
    }
};
