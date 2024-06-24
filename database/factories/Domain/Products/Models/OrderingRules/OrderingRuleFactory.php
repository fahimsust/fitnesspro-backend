<?php

namespace Database\Factories\Domain\Products\Models\OrderingRules;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\MatchAllAnyString;

class OrderingRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderingRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'status' => 1,
            'any_all' => MatchAllAnyString::ANY
        ];
    }
}
