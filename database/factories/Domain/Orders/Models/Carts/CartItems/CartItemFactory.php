<?php

namespace Database\Factories\Domain\Orders\Models\Carts\CartItems;

use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CartItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cart_id' => Cart::firstOrFactory(),
            'product_id' => Product::firstOrFactory(),
            'qty' => $this->faker->randomNumber(2),
            'price_reg' => $this->faker->randomFloat(2,200,250),
            'price_sale' => $this->faker->randomFloat(2,150,199),
            'onsale' => (int)$this->faker->boolean(),
        ];
    }
}
