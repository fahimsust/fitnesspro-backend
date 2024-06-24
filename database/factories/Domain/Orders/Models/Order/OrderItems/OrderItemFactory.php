<?php

namespace Database\Factories\Domain\Orders\Models\Order\OrderItems;

use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
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
        $product = Product::firstOrFactory();

        return [
            'order_id' => Order::firstOrFactory(),
            'product_id' => $product->id,
            'product_qty' => 1,
            'product_price' => $this->faker->randomFloat(2, 1, 999),
            'product_notes' => "",
            'product_saleprice' => $this->faker->randomFloat(2, 1, 999),
            'product_onsale' => 0,
            'actual_product_id' => $product->id,
            'package_id' => OrderPackage::firstOrFactory(),
            'parent_product_id' => null,
            'product_label' => "",
            'registry_item_id' => null,
            'free_from_discount_advantage' => 0,
        ];
    }
}
