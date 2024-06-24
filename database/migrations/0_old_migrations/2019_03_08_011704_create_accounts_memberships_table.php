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
        Schema::create('accounts_memberships', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('membership_id');
            $table->decimal('amount_paid');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('account_id')->index('amem_account_id');
            $table->integer('order_id');
            $table->decimal('subscription_price');
            $table->integer('product_id');
            $table->boolean('status')->default(1);
            $table->dateTime('created');
            $table->dateTime('cancelled')->nullable();
            $table->boolean('expirealert1_sent');
            $table->boolean('expirealert2_sent');
            $table->boolean('expire_sent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_memberships');
    }
};
