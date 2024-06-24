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
        Schema::create('inventory_gateways_scheduledtasks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('gateway_account_id')->index('gateway_account_id');
            $table->tinyInteger('task_type')->comment('1=update product prices, 2=update product inventory, 3=load new products');
            $table->integer('task_start');
            $table->dateTime('task_startdate');
            $table->boolean('task_status')->comment('0=waiting, 1=processing');
            $table->integer('task_modified');
            $table->string('task_custom_info', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_gateways_scheduledtasks');
    }
};
