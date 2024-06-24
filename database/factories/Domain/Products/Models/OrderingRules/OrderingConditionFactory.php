<?php

namespace Database\Factories\Domain\Products\Models\OrderingRules;

use Domain\Products\Enums\OrderingConditionTypes;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\MatchAllAnyString;

class OrderingConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderingCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rule_id' => OrderingRule::firstOrFactory(),
            'status' => true,
            'type' => $this->faker->randomElement(OrderingConditionTypes::cases()),
            'any_all' => MatchAllAnyString::ANY
        ];
    }
}
