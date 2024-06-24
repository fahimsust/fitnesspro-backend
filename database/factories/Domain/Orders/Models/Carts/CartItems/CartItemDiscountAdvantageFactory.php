<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartItems;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountAdvantage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Carts\CartItems\CartItemOptionOld>
 */
class CartItemDiscountAdvantageFactory extends Factory
{
    protected $model = CartItemDiscountAdvantage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'item_id' => CartItem::firstOrFactory(),
            'cart_discount_id' => CartDiscount::firstOrFactory(),
            'advantage_id' => DiscountAdvantage::firstOrFactory(),
            'qty' => 1,
            'amount' => 2.00,
        ];
    }
}
