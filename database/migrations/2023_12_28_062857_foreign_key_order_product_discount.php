<?php

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemDiscount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(OrderItemDiscount::Table(), function (Blueprint $table) {
            $table->dropForeign(['orders_products_id']);
            $table->dropForeign(['discount_id']);
            $table->dropForeign(['advantage_id']);
            $table->foreign('orders_products_id')
                ->references('id')->on(OrderItem::Table())->onDelete('cascade');
            $table->foreign('discount_id')
                ->references('id')->on(Discount::Table())->onDelete('cascade');
            $table->foreign('advantage_id')
                ->references('id')->on(DiscountAdvantage::Table())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
