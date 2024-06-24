<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionMembershipLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConditionMembershipLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => DiscountCondition::firstOrFactory(),
            'membershiplevel_id' => MembershipLevel::firstOrFactory()
        ];
    }
}
