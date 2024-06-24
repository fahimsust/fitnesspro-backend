<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Discounts\Models\Rule\Condition\ConditionOnSaleStatus;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionOnSaleStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConditionOnSaleStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => DiscountCondition::firstOrFactory(),
            'onsalestatus_id' => 0,
            'required_qty'=>0
        ];
    }
}
