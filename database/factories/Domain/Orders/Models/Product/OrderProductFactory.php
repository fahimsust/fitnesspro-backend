<?php

namespace Database\Factories\Domain\Orders\Models\Product;

use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $regularPrice = $this->faker->randomFloat(2, null, 10000);

        return [
            'order_id' => function () {
                return Order::firstOrFactory()->id;
            },
            'product_id' => function () {
                return Product::firstOrFactory()->id;
            },
            'product_qty' => $this->faker->randomDigit,
            'product_price' => $regularPrice,
            'product_notes' => '',
            'product_saleprice' => $this->faker->randomFloat(2, 0, $regularPrice - 0.1),
            'product_onsale' => $this->faker->boolean(),
            'actual_product_id' => 0,
            'package_id' => function () {
                return OrderPackage::firstOrFactory()->id;
            },
            'parent_product_id' => 0,
            'cart_id' => 0,
            'product_label' => '',
            'registry_item_id' => 0,
            'free_from_discount_advantage' => 0,
        ];
    }
}
