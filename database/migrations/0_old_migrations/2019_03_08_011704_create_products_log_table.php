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
        Schema::create('products_log', function (Blueprint $table) {
            $table->integer('product_id')->index('prlo_product_id');
            $table->integer('id', true);
            $table->integer('productdistributor_id')->index('prlo_productdistributor_id');
            $table->tinyInteger('action_type')->comment('0=stock qty change');
            $table->string('changed_from', 85);
            $table->string('changed_to', 85);
            $table->dateTime('logged')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_log');
    }
};
