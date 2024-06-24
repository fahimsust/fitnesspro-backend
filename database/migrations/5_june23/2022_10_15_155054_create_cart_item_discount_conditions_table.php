<?php

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountCondition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    use \Support\Traits\HasMigrationUtilities;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CartItemDiscountCondition::Table(), function (Blueprint $table) {
            $table->id();
            $this->defaultTimestamps($table);
            $table->foreignId('item_id')->constrained(CartItem::Table())->cascadeOnDelete();
            $table->foreignId('condition_id')->constrained(DiscountCondition::Table());
            $table->integer('qty')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CartItemDiscountCondition::Table());
    }
};
