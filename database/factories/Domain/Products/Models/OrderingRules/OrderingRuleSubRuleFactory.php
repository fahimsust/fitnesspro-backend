<?php

namespace Database\Factories\Domain\Products\Models\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleSubRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderingRuleSubRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderingRuleSubRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_rule_id' => OrderingRule::firstOrFactory(),
            'child_rule_id' => function () {
                return OrderingRule::factory()->create();
            }
        ];
    }
}
