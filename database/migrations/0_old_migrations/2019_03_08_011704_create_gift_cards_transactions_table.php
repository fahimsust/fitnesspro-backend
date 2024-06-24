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
        Schema::create('gift_cards_transactions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('giftcard_id')->index('giftcard_id');
            $table->decimal('amount');
            $table->boolean('action')->comment('0=credit,1=debit');
            $table->string('notes', 85);
            $table->integer('admin_user_id');
            $table->integer('order_id')->index('order_id');
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
        Schema::dropIfExists('gift_cards_transactions');
    }
};
