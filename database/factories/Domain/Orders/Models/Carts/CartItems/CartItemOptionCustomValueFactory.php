<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartItems;

use Domain\Orders\Models\Carts\CartItems\CartItemOption;
use Domain\Orders\Models\Carts\CartItems\CartItemOptionCustomValueUNUSED;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Carts\CartItems\CartItemOptionCustomValueUNUSED>
 */
class CartItemOptionCustomValueFactory extends Factory
{
    protected $model = CartItemOptionCustomValueUNUSED::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'item_option_id' => CartItemOption::firstOrFactory(),
            'custom_value' => $this->faker->word
        ];
    }
}
