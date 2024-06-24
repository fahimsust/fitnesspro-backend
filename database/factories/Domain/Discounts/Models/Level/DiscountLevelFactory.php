<?php

namespace Database\Factories\Domain\Discounts\Models\Level;

use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Level\DiscountLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\MatchAllAnyInt;

class DiscountLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscountLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'apply_to' => 0,
            'action_type' => 0,
            'action_percentage' => $this->faker->randomFloat(2, 0, 100),
            'action_sitepricing' => 0,
            'status' => 1,
        ];
    }
}
