<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartDiscounts;

use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscount;
use Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Carts\CartDiscounts\CartDiscountCode>
 */
class CartDiscountCodeFactory extends Factory
{
    protected $model = CartDiscountCode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cart_discount_id' => CartDiscount::firstOrFactory(),
            'condition_id' => DiscountCondition::firstOrFactory(),
            'code' => $this->faker->uuid
        ];
    }
}
