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
        Schema::create('accounts_loyaltypoints_credits', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('aloy_account_id');
            $table->integer('loyaltypoints_level_id');
            $table->integer('shipment_id')->index('aloy_shipment_id');
            $table->integer('points_awarded');
            $table->boolean('status')->comment('0=pending, 1=credited');
            $table->dateTime('created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_loyaltypoints_credits');
    }
};
