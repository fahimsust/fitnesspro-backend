<?php

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Support\Traits\HasMigrationUtilities;

return new class extends Migration {
    use HasMigrationUtilities;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CartItemOption::Table(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')
                ->constrained(CartItem::Table())
                ->cascadeOnDelete();

            $table->foreignId('option_value_id')
                ->constrained(ProductOptionValue::Table());

            $table->unique(['item_id', 'option_value_id'], 'item_option_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CartItemOption::Table());
    }
};
