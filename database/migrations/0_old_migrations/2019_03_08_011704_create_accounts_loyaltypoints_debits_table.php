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
        Schema::create('accounts_loyaltypoints_debits', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('account_id')->index('aloyd_account_id');
            $table->integer('loyaltypoints_level_id');
            $table->integer('order_id')->index('aloyd_order_id');
            $table->integer('points_used');
            $table->dateTime('created');
            $table->text('notes');
            $table->unique(['account_id', 'loyaltypoints_level_id', 'order_id'], 'aloyd_account_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_loyaltypoints_debits');
    }
};
