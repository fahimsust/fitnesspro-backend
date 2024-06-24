<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartDiscounts;

use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartDiscountFactory extends Factory
{
    protected $model = CartDiscount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cart_id' => Cart::firstOrFactory(),
            'discount_id' => Discount::firstOrFactory(),
            'applied' => 0
        ];
    }
}
