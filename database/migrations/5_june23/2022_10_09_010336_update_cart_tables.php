<?php

use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Cart::Table(), function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('account_id')->nullable()->change();
            $table->integer('status')->default(1)->change();

            $table->timestamp('created_at')
                ->useCurrent();
            $table->timestamp('updated_at')
                ->nullable()
                ->useCurrentOnUpdate();
        });

        DB::update('UPDATE '.Cart::Table().' SET created_at=created, updated_at=modified');

        Schema::table(Cart::Table(), function (Blueprint $table) {
            if (!Schema::hasColumn($table->getTable(), 'modified'))
                return;

            $table->dropColumn(['created', 'modified']);
        });

        Schema::table(CartItem::Table(), function (Blueprint $table) {
            if (!Schema::hasColumn($table->getTable(), 'parent_cart_id'))
                return;

            $table->renameColumn('parent_cart_id', 'parent_cart_item_id');
        });

        Schema::table(OrderItem::Table(), function (Blueprint $table) {
            if (Schema::hasColumn($table->getTable(), 'cart_item_id'))
                return;

            $table->foreignId('cart_item_id')
                ->nullable()
                ->constrained(CartItem::Table());
        });

        if (Schema::hasColumn(CartItem::Table(), 'cart_id')) {
            DB::update('UPDATE ' . CartItem::Table() . ' c
JOIN ' . CartItem::Table() . ' p ON p.cart_id=c.parent_cart_item_id
SET c.parent_cart_item_id = p.id');

            DB::update('UPDATE ' . CartItem::Table() . ' c
JOIN ' . CartItem::Table() . ' p ON p.cart_id=c.required
SET c.required = p.id');

            DB::update('UPDATE ' . OrderItem::Table() . ' c
JOIN ' . CartItem::Table() . ' p ON p.cart_id=c.cart_id
SET c.cart_item_id = p.id');

            Schema::table(CartItem::Table(), function (Blueprint $table) {
                $table->dropColumn('cart_id');
            });
        }

        Schema::table(CartItem::Table(), function (Blueprint $table) {
            if (!Schema::hasColumn($table->getTable(), 'saved_cart_id'))
                return;

            $table->renameColumn('saved_cart_id', 'cart_id');
        });

        Schema::table(OrderItem::Table(), function (Blueprint $table) {
            if (!Schema::hasColumn($table->getTable(), 'cart_id'))
                return;

            $table->dropColumn('cart_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
