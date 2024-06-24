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
        Schema::create('inventory_gateways', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 55);
            $table->string('class_name', 50);
            $table->boolean('status');
            $table->tinyInteger('loadproductsby')->comment('0=date, 1=id');
            $table->text('price_fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_gateways');
    }
};
