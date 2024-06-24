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
        Schema::create('shipping_label_sizes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100);
            $table->integer('gateway_id');
            $table->string('carrier_code', 55);
            $table->boolean('default');
            $table->boolean('status');
            $table->integer('label_template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_label_sizes');
    }
};
