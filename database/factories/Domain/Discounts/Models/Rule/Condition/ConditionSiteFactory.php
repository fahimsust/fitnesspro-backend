<?php

namespace Database\Factories\Domain\Discounts\Models\Rule\Condition;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionSite;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConditionSiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConditionSite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'condition_id' => DiscountCondition::firstOrFactory(),
            'site_id' => Site::firstOrFactory()
        ];
    }
}
