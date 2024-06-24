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
        Schema::create('shipping_carriers_shipto', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('shipping_carriers_id')->index('shipping_carriers_id');
            $table->integer('country_id');
            $table->unique(['shipping_carriers_id', 'country_id'], 'shipping_carriers_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_carriers_shipto');
    }
};
