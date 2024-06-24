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
        Schema::create('bulkedit_change_products', function (Blueprint $table) {
            $table->integer('change_id');
            $table->integer('product_id');
            $table->text('changed_from');
            $table->unique(['change_id', 'product_id'], 'change_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulkedit_change_products');
    }
};
