<?php

namespace Database\Factories\Domain\Orders\Models\Order\OrderItems;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemOptionOld;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemOptionOldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItemOptionOld::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'orders_products_id' => OrderItem::firstOrFactory(),
            'value_id' => ProductOptionValue::firstOrFactory(),
            'price' => $this->faker->randomFloat(2, 1, 999),
            'custom_value' => "",
        ];
    }
}
