<?php

namespace Database\Factories\Domain\Sites\Models;

use Domain\Sites\Models\InventoryRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InventoryRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        return [
            'action'=>$faker->boolean,
            'min_stock_qty'=>$faker->randomDigit,
            'max_stock_qty'=>$faker->randomDigit,
            'availabity_changeto'=>$faker->randomDigit,
            'label'=>$faker->word,
        ];
    }
}
