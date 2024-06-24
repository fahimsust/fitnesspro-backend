<?php

namespace Database\Factories\Domain\Orders\Models\Checkout;

use Domain\Orders\Models\Carts\CartItems\CartItem;
use Domain\Orders\Models\Checkout\CheckoutItem;
use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Checkout\CheckoutItem>
 */
class CheckoutItemFactory extends Factory
{
    protected $model = CheckoutItem::class;

    public function definition(): array
    {
        return [
            'package_id' => CheckoutPackage::firstOrFactory(),
            'product_id' => Product::firstOrFactory(),
            'cart_item_id' => CartItem::firstOrFactory(),
            'qty' => $this->faker->numberBetween(1, 10),
        ];
    }
}
