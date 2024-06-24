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
        Schema::create('orders_packages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('shipment_id')->index('orpa_shipment_id');
            $table->integer('package_type');
            $table->integer('package_size');
            $table->boolean('is_dryice');
            $table->decimal('dryice_weight', 5, 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_packages');
    }
};
