<?php

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
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
        Schema::create(CartDiscountAdvantage::Table(), function (Blueprint $table) {
            $table->id();
            $this->defaultTimestamps($table);
            $table->foreignId('cart_id')
                ->constrained(Cart::Table())
                ->cascadeOnDelete();
            $table->foreignId('advantage_id')
                ->constrained(DiscountAdvantage::Table())
                ->cascadeOnDelete();
            $table->unsignedBigInteger('amount')->nullable();

//            $table->unique(['cart_id', 'advantage_id'], 'cart_advantage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CartDiscountAdvantage::Table());
    }
};
