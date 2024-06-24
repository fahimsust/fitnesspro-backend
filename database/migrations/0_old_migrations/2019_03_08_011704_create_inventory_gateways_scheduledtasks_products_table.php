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
        Schema::create('inventory_gateways_scheduledtasks_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('task_id')->index('task_id');
            $table->integer('products_id')->index('products_id');
            $table->integer('products_distributors_id')->index('products_distributors_id');
            $table->dateTime('created')->useCurrent();
            $table->index(['task_id', 'products_id'], 'taskproducts');
            $table->index(['task_id', 'products_distributors_id'], 'taskproductsdist');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_gateways_scheduledtasks_products');
    }
};
