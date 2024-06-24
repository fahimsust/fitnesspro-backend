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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no', 20);
            $table->bigInteger('account_id');
            $table->bigInteger('account_billing_id');
            $table->bigInteger('account_shipping_id');
            $table->string('order_phone', 15)->comment('only use if no account');
            $table->string('order_email', 85)->comment('only use if no account');
            $table->timestamp('order_created')->useCurrent();
            $table->integer('payment_method');
            $table->decimal('payment_method_fee', 8, 4)->nullable();
            $table->decimal('addtl_discount', 10, 2);
            $table->decimal('addtl_fee', 10, 2);
            $table->text('comments');
            $table->bigInteger('site_id');
            $table->boolean('status')->comment('0 = active, 1 = archived');
            $table->bigInteger('inventory_order_id');

            $table->index('account_id');

//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
