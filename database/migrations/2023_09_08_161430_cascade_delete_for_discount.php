<?php

use Domain\Discounts\Models\Advantage\AdvantageProduct;
use Domain\Discounts\Models\Advantage\AdvantageProductType;
use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
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
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableRelations = [
            DiscountCondition::Table() => ['column' => 'rule_id', 'reference' => DiscountRule::Table()],
            DiscountRule::Table() => ['column' => 'discount_id', 'reference' => Discount::Table()],
            DiscountAdvantage::Table() => ['column' => 'discount_id', 'reference' => Discount::Table()],
            AdvantageProduct::Table() => ['column' => ['advantage_id', 'product_id'], 'reference' => [DiscountAdvantage::Table(), Product::Table()]],
            AdvantageProductType::Table() => ['column' => 'advantage_id', 'reference' => DiscountAdvantage::Table()],
            ConditionAccountType::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
            ConditionAttribute::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
            ConditionCountry::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
            ConditionDistributor::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
            ConditionMembershipLevel::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
            ConditionOnSaleStatus::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
            ConditionOutOfStockStatus::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
            ConditionProductAvailability::Table() => ['column' => 'condition_id', 'foreign_key' => 'con_id', 'reference' => DiscountCondition::Table()],
            ConditionProduct::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
            ConditionProductType::Table() => ['column' => 'condition_id', 'foreign_key' => 'cond_id', 'reference' => DiscountCondition::Table()],
            ConditionSite::Table() => ['column' => 'condition_id', 'reference' => DiscountCondition::Table()],
        ];

        // First, update the foreign key columns if they are set to 0
        foreach ($tableRelations as $tableName => $relation) {
            if (is_array($relation['column'])) {
                foreach ($relation['column'] as $column) {
                    DB::table($tableName)->where($column, 0)->update([$column => null]);
                }
            } else {
                DB::table($tableName)->where($relation['column'], 0)->update([$relation['column'] => null]);
            }
        }

        foreach ($tableRelations as $tableName => $relation) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName, $relation) {
                if (is_array($relation['column'])) {
                    foreach ($relation['column'] as $index => $column) {
                        $foreignKeyName = 'fk_' . "{$tableName}_{$column}";

                        $hasForeignKey = DB::selectOne(
                            "SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME LIKE ? AND CONSTRAINT_TYPE = 'FOREIGN KEY' LIMIT 1",
                            [
                                config('database.connections.mysql.database'),
                                $tableName,
                                '%' . $column . '%',
                            ]
                        );

                        if ($hasForeignKey) {
                            $table->dropForeign($hasForeignKey->CONSTRAINT_NAME);
                        }
                        $table->foreign($column, $foreignKeyName)->references('id')->on($relation['reference'][$index])->onDelete('cascade');
                    }
                } else {
                    $foreign_key = $relation['column'];
                    if (isset($relation['foreign_key'])) {
                        $foreign_key = $relation['foreign_key'];
                    }
                    $foreignKeyName = 'fk_' . "{$tableName}_{$relation['column']}";

                    $hasForeignKey = DB::selectOne(
                        "SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME LIKE ? AND CONSTRAINT_TYPE = 'FOREIGN KEY' LIMIT 1",
                        [
                            config('database.connections.mysql.database'),
                            $tableName,
                            '%' . $foreign_key . '%',
                        ]
                    );

                    if ($hasForeignKey) {
                        $table->dropForeign($hasForeignKey->CONSTRAINT_NAME);
                    }
                    $table->foreign($relation['column'], $foreignKeyName)->references('id')->on($relation['reference'])->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
