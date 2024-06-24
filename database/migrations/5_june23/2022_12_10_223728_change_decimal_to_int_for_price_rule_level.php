<?php

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Pricing\PricingRuleLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table(PricingRuleLevel::Table(), function (Blueprint $table) {
        //     $table->bigInteger('amount')->change();
        // });

        // Schema::table(CartItem::Table(), function (Blueprint $table) {
        //     $table->bigInteger('price_reg')->change();
        //     $table->bigInteger('price_sale')->change();
        // });
    }
};
