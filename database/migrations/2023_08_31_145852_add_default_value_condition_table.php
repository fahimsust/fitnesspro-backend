<?php

use Domain\Discounts\Enums\DiscountConditionRequiredQtyTypes;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(DiscountCondition::table(), function (Blueprint $table) {
            $table->string('required_code',25)->nullable()->change();
            $table->integer('required_qty_type')
                ->default(DiscountConditionRequiredQtyTypes::Combined->value)
                ->change();
            $table->integer('required_qty_combined')->default(1)->change();
            $table->boolean('match_anyall')->default(0)->change();
            $table->boolean('equals_notequals')->default(0)->change();
            $table->boolean('use_with_rules_products')->default(0)->change();
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
