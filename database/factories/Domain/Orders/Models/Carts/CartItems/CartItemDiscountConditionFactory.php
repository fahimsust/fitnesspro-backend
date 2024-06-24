<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartItems;

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemDiscountCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Carts\CartItems\CartItemOptionOld>
 */
class CartItemDiscountConditionFactory extends Factory
{
    protected $model = CartItemDiscountCondition::class;

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
            'condition_id' => DiscountCondition::firstOrFactory(),
            'qty' => $this->faker->randomNumber(1),
        ];
    }
}
