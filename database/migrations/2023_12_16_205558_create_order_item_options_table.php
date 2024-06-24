<?php

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
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
        Schema::create(OrderItemOption::Table(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')
                ->constrained(OrderItem::Table())
                ->cascadeOnDelete();

            $table->foreignId('option_value_id')
                ->constrained(ProductOptionValue::Table());
            $table->json('custom_value')->nullable();

            $table->unique(['item_id', 'option_value_id'], 'item_option_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(OrderItemOption::Table());
    }
};
