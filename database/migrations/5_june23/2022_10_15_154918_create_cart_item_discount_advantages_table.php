<?php

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Support\Traits\HasMigrationUtilities;

return new class extends Migration
{
    use HasMigrationUtilities;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(CartItemDiscountAdvantage::Table(), function (Blueprint $table) {
            $table->id();
            $this->defaultTimestamps($table);
            $table->foreignId('item_id')->constrained(CartItem::Table())->cascadeOnDelete();
            $table->foreignId('advantage_id')->constrained(DiscountAdvantage::Table());
            $table->integer('qty')->default(1);
            $table->unsignedBigInteger('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CartItemDiscountAdvantage::Table());
    }
};
