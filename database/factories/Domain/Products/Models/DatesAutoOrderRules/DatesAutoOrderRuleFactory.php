<?php

namespace Database\Factories\Domain\Products\Models\DatesAutoOrderRules;

use Domain\Products\Models\DatesAutoOrderRules\DatesAutoOrderRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatesAutoOrderRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatesAutoOrderRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'status' => $this->faker->boolean,
        ];
    }
}
