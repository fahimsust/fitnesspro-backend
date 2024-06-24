<?php

namespace Database\Factories\Domain\Discounts\Models\Rule;

use Domain\Discounts\Models\Discount;
use Domain\Discounts\Models\Rule\DiscountRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscountRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiscountRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'discount_id' => Discount::firstOrFactory(),
            'match_anyall' => 0,
			'rank' => mt_rand(1, 10)
        ];
    }
}
