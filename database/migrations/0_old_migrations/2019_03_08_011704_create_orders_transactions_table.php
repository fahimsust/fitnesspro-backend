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
        Schema::create('orders_transactions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id')->index('ortr_order_id');
            $table->string('transaction_no', 35);
            $table->decimal('amount', 10);
            $table->decimal('original_amount', 10);
            $table->string('cc_no', 4);
            $table->date('cc_exp');
            $table->text('notes');
            $table->tinyInteger('status')->comment('1 = Authorized, 2 = Captured, 3 = Voided');
            $table->integer('account_billing_id');
            $table->integer('payment_method_id');
            $table->integer('gateway_account_id');
            $table->dateTime('created');
            $table->dateTime('updated')->nullable();
            $table->integer('cim_payment_profile_id');
            $table->integer('capture_on_shipment');
            $table->dateTime('voided_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_transactions');
    }
};
