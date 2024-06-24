<?php

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Domain\Orders\Models\Carts\CartItems\CartItem;
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
        Schema::table(CartItem::Table(), function (Blueprint $table) {
            $table->unsignedBigInteger('required')->nullable()->change();
            $table->unsignedBigInteger('accessory_link_actions')
                ->nullable()
                ->change();

            foreach ([
                         'parent_cart_item_id',
                         'required',
                         'accessory_link_actions'
                     ] as $field) {
                $table->foreign($field)
                    ->on(CartItem::Table())
                    ->references('id')
                    ->cascadeOnDelete();
            }
        });

        Schema::create(CartDiscountCode::Table(), function (Blueprint $table) {
            $table->id();
            $this->defaultTimestamps($table);
            $table->foreignId('cart_id')
                ->constrained(Cart::Table())
                ->cascadeOnDelete();
            $table->foreignId('condition_id')
                ->constrained(DiscountCondition::Table())
                ->cascadeOnDelete();;
            $table->string('code');

            $table->unique(['cart_id', 'condition_id', 'code'], 'cart_code_unq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CartDiscountCode::Table());
    }
};
