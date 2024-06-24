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
        Schema::create('products_distributors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('product_id')->index('prdi_product_id');
            $table->integer('distributor_id');
            $table->decimal('stock_qty');
            $table->tinyInteger('outofstockstatus_id')->nullable();
            $table->decimal('cost', 12, 4)->nullable();
            $table->string('inventory_id', 155)->index('prdi_inventory_id');
            $table->index(['product_id', 'distributor_id'], 'prdi_proddist');
            $table->unique(['product_id', 'distributor_id', 'inventory_id'], 'prdi_product_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_distributors');
    }
};
