<?php

namespace Database\Factories\Domain\Products\Models\FulfillmentRules;

use Domain\Products\Models\FulfillmentRules\FulfillmentRule;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\MatchAllAnyString;

class FulfillmentRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FulfillmentRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status'=>$this->faker->boolean,
            'any_all'=>$this->faker->randomElement(MatchAllAnyString::cases())
        ];
    }
}
