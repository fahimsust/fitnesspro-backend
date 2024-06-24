<?php

namespace Database\Factories\Domain\Products\Models\Product\Pricing;

use Domain\Products\Models\Product\Pricing\PricingRule;
use Domain\Products\Models\Product\Pricing\PricingRuleLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\AmountAdjustmentTypes;

class PricingRuleLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PricingRuleLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rule_id' => PricingRule::firstOrFactory(),
            'amount_type' => $this->faker->randomElement(AmountAdjustmentTypes::cases()),
            'amount' => mt_rand(10, 50),
            'min_qty' => 1,
            'max_qty' => 0
        ];
    }
}
