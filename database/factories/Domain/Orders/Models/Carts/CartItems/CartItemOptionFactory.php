<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartItems;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Carts\CartItems\CartItemOptionOld>
 */
class CartItemOptionFactory extends Factory
{
    protected $model = CartItemOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'item_id' => CartItem::firstOrFactory(),
            'option_value_id' => ProductOptionValue::firstOrFactory(),
        ];
    }
}
