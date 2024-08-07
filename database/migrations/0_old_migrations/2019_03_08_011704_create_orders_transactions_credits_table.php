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
        Schema::create('orders_transactions_credits', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('orders_transactions_id')->index('orders_transactions_id');
            $table->decimal('amount', 10);
            $table->dateTime('recorded');
            $table->string('transaction_id', 35);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_transactions_credits');
    }
};
