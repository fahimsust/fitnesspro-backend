<?php

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemCustomField;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Orders\Models\Carts\CartItems\CartItemOptionCustomValueUNUSED;
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
        if (!Schema::hasTable(CartItemCustomField::Table()))
            Schema::rename(
                'cart_items_customfields',
                CartItemCustomField::Table()
            );

        Schema::table(CartItem::Table(), function (Blueprint $table) {
            $table->string('product_label', 155)->nullable()->change();
        });

        if (Schema::hasColumn(CartItemCustomField::Table(), 'cart_item_id'))
            Schema::table(CartItemCustomField::Table(), function (Blueprint $table) {
                $table->renameColumn('cart_item_id', 'item_id');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(CartItemOptionCustomValueUNUSED::Table());
    }
};
