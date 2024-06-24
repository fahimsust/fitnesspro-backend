<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Discounts\Models\Rule\Condition\ConditionOutOfStockStatus;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionOutOfStockStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConditionOutOfStockStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => DiscountCondition::firstOrFactory(),
            'outofstockstatus_id' => ProductAvailability::firstOrFactory(),
            'required_qty'=>1
        ];
    }
}
