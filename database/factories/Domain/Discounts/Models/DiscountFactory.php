<?php

namespace Database\Factories\Domain\Discounts\Models;

use Domain\Discounts\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Enums\MatchAllAnyInt;

class DiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Discount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => 1,
            'match_anyall' => MatchAllAnyInt::ALL,
            'limit_per_order' => 0,
            'limit_per_customer' => 0,
            'limit_uses' => 0,
            'start_date' => null,
            'exp_date' => null,
            'name' => $this->faker->word,
            'display' => $this->faker->word,

        ];
    }
}
