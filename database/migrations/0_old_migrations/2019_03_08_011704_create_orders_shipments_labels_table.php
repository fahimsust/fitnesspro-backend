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
        Schema::create('orders_shipments_labels', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('shipment_id')->index('orsila_shipment_id');
            $table->integer('package_id')->index('orsila_package_id');
            $table->string('filename', 100)->unique('orsila_filename');
            $table->integer('label_size_id');
            $table->string('gateway_label_id', 55);
            $table->string('tracking_no', 65);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_shipments_labels');
    }
};
