<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Discounts\Enums\DiscountConditionRequiredQtyTypes;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\Condition\DiscountConditionType;
use Domain\Discounts\Models\Rule\DiscountRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscountCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'rule_id' => DiscountRule::firstOrFactory(),
            'condition_type_id' => $this->faker->randomElement(DiscountConditionTypes::cases()),// DiscountConditionType::firstOrFactory(),
            'required_cart_value' => 0.00,
            'required_code' => $this->faker->bothify('????####'),
            'required_qty_type' => DiscountConditionRequiredQtyTypes::Combined,
            'match_anyall' => 0,
            'equals_notequals' => 0,
            'use_with_rules_products' => 0
        ];
    }
}
