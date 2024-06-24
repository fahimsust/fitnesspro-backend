<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table(Order::Table(), function (Blueprint $table) {
        //     $table->decimal('addtl_discount',10)->change();
        //     $table->bigInteger('addtl_fee',10)->change();
        //     $table->bigInteger('payment_method_fee',10)->nullable()->change();
        // });
        // Schema::table(Shipment::Table(), function (Blueprint $table) {
        //     $table->bigInteger('cod_amount',10)->change();
        //     $table->bigInteger('insured_value',10)->change();
        //     $table->bigInteger('ship_cost')->change();
        // });
        // //varchar
        // Schema::table(OrderDiscount::Table(), function (Blueprint $table) {
        //     $table->bigInteger('amount')->change();
        // });
        // Schema::table(OrderItem::Table(), function (Blueprint $table) {
        //     $table->bigInteger('product_price')->change();
        //     $table->bigInteger('product_saleprice')->change();
        // });
        // Schema::table(OrderTransaction::Table(), function (Blueprint $table) {
        //     $table->bigInteger('amount')->change();
        //     $table->bigInteger('original_amount')->change();
        // });
        // Schema::table(OrderItemOption::Table(), function (Blueprint $table) {
        //     $table->bigInteger('price')->change();
        // });
        // //varchar
        // Schema::table(OrderItemDiscount::Table(), function (Blueprint $table) {
        //     $table->bigInteger('amount')->change();
        // });
        // Schema::table(OrderItemCustoms::Table(), function (Blueprint $table) {
        //     $table->bigInteger('customs_value')->change();
        //     $table->bigInteger('customs_weight')->change();
        // });
        // Schema::table(OrderTransactionRefund::Table(), function (Blueprint $table) {
        //     $table->bigInteger('amount')->change();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
