<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Discounts\Models\Rule\Condition\ConditionAttribute;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Attribute\AttributeOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConditionAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => DiscountCondition::firstOrFactory(),
            'attributevalue_id' => AttributeOption::firstOrFactory(),
            'required_qty'=>0
        ];
    }
}
