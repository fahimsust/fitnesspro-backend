<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Accounts\Models\AccountType;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionAccountTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConditionAccountType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => DiscountCondition::firstOrFactory(),
            'accounttype_id' => AccountType::firstOrFactory()
        ];
    }
}
