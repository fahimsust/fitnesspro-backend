<?php

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
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
        Schema::dropIfExists('cart_discounts');

        Schema::create(CartDiscount::Table(), function (Blueprint $table) {
            $table->id();
            $this->defaultTimestamps($table);

            $table->foreignId('cart_id')
                ->constrained(Cart::Table())
                ->cascadeOnDelete();

            $table->foreignId('discount_id')
                ->constrained(Discount::Table());

            $table->integer('applied')->default(1);
        });

        foreach ([
                     CartDiscountAdvantage::Table(),
                     CartItemDiscountAdvantage::Table(),
                     CartItemDiscountCondition::Table(),
                     CartDiscountCode::Table()
                 ] as $tableName) {
            if (Schema::hasColumn($tableName, 'cart_discount_id'))
                continue;

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'cart_id')) {
                    $table->dropForeignIdFor(Cart::class);
                    $table->dropColumn('cart_id');
                }

                $table->foreignId('cart_discount_id')
                    ->constrained(CartDiscount::Table())
                    ->cascadeOnDelete();
            });
        }

        Schema::table(CartDiscountAdvantage::Table(), function (Blueprint $table) {
            $table->unique(['cart_discount_id', 'advantage_id'], 'cartdiscount_advantage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CartDiscount::Table());
    }
};
