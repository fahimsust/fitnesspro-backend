<?php

use Domain\Orders\Models\Carts\Cart;
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
        Schema::table(Cart::Table(), function (Blueprint $table) {
            $table->foreignId('site_id')->nullable()->constrained(\Domain\Sites\Models\Site::Table());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Cart::Table(), function (Blueprint $table) {
            //
        });
    }
};
