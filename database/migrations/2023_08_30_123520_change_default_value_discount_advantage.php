<?php

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Distributors\Models\Distributor;
use Domain\Locales\Models\Country;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(DiscountAdvantage::table(), function (Blueprint $table) {
            $table->dropForeign(['apply_shipping_id']);
            $table->decimal('amount', 10)->default(0.00)->nullable()->change();
            $table->unsignedBigInteger('apply_shipping_id')->default(null)->nullable()->change();
            $table->unsignedBigInteger('apply_shipping_country')->default(null)->nullable()->change();
            $table->unsignedBigInteger('apply_shipping_distributor')->default(null)->nullable()->change();
            $table->integer('applyto_qty_type')->default(0)->nullable()->change();
            $table->integer('applyto_qty_combined')->default(1)->nullable()->change();

            DB::table(DiscountAdvantage::table())
                ->where('apply_shipping_country', 0)
                ->update(['apply_shipping_country' => DB::raw('NULL')]);

            DB::table(DiscountAdvantage::table())
                ->where('apply_shipping_id', 0)
                ->update(['apply_shipping_id' => DB::raw('NULL')]);

            DB::table(DiscountAdvantage::table())
                ->where('apply_shipping_distributor', 0)
                ->update(['apply_shipping_distributor' => DB::raw('NULL')]);

            $table->foreign('apply_shipping_id')
              ->references('id')->on(ShippingMethod::Table())->onDelete('cascade');
            $table->foreign('apply_shipping_country')
              ->references('id')->on(Country::Table())->onDelete('cascade');
            $table->foreign('apply_shipping_distributor')
              ->references('id')->on(Distributor::Table())->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
