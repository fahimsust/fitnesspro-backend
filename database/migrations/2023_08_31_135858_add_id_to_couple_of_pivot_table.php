<?php

use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Discounts\Models\Rule\Condition\ConditionAttribute;
use Domain\Discounts\Models\Rule\Condition\ConditionCountry;
use Domain\Discounts\Models\Rule\Condition\ConditionDistributor;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionOnSaleStatus;
use Domain\Discounts\Models\Rule\Condition\ConditionOutOfStockStatus;
use Domain\Discounts\Models\Rule\Condition\ConditionProduct;
use Domain\Discounts\Models\Rule\Condition\ConditionProductAvailability;
use Domain\Discounts\Models\Rule\Condition\ConditionProductType;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
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
        Schema::table(ConditionProduct::table(), function (Blueprint $table) {
            $table->id();
        });
        Schema::table(ConditionSite::table(), function (Blueprint $table) {
            $table->id();
        });
        Schema::table(ConditionCountry::table(), function (Blueprint $table) {
            $table->id();
        });
        Schema::table(ConditionAttribute::table(), function (Blueprint $table) {
            $table->id();
        });
        Schema::table(ConditionAccountType::table(), function (Blueprint $table) {
            $table->id();
        });

        Schema::table(ConditionDistributor::table(), function (Blueprint $table) {
            $table->id();
        });
        Schema::table(ConditionProductType::table(), function (Blueprint $table) {
            $table->id();
        });
        Schema::table(ConditionOnSaleStatus::table(), function (Blueprint $table) {
            $table->id();
        });

        Schema::table(ConditionMembershipLevel::table(), function (Blueprint $table) {
            $table->id();
        });
        Schema::table(ConditionOutOfStockStatus::table(), function (Blueprint $table) {
            $table->id();
        });
        Schema::table(ConditionProductAvailability::table(), function (Blueprint $table) {
            $table->id();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('couple_of_pivot', function (Blueprint $table) {
            //
        });
    }
};
