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
        Schema::create('products_needschildren', function (Blueprint $table) {
            $table->integer('product_id')->index('prne_product_id');
            $table->integer('option_id');
            $table->integer('qty');
            $table->text('account_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_needschildren');
    }
};
