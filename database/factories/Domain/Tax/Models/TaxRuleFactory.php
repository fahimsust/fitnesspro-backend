<?php

namespace Database\Factories\Domain\Tax\Models;

use Domain\Tax\Models\TaxRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'rate' => $this->faker->randomDigit,
            'type' => $this->faker->boolean
        ];
    }
}
