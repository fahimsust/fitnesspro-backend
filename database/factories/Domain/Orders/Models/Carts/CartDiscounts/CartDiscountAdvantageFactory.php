<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartDiscounts;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Carts\CartDiscounts\CartDiscountAdvantage>
 */
class CartDiscountAdvantageFactory extends Factory
{
    protected $model = CartDiscountAdvantage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cart_discount_id' => CartDiscount::firstOrFactory(),
            'advantage_id' => DiscountAdvantage::firstOrFactory(),
            'amount' => $this->faker->randomFloat(2,10,99)
        ];
    }
}
