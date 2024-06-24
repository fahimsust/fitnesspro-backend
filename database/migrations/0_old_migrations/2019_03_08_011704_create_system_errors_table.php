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
        Schema::create('system_errors', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent')->index('parent');
            $table->dateTime('created');
            $table->text('error');
            $table->text('details');
            $table->text('moredetails');
            $table->integer('type_id');
            $table->tinyInteger('type')->comment('0 = general system error, 1 = inventory gateway error, 2 = order error, 3 = order shipment error, 4 = order package error');
            $table->integer('type_subid');
            $table->boolean('been_read');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_errors');
    }
};
