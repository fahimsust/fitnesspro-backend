<?php

namespace Database\Factories\Domain\Orders\Models\Product;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemOptionOld;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductOptionFactory extends Factory
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
            'orders_products_id' => function () {
                return OrderItem::firstOrFactory()->id;
            },
            'value_id' => function () {
                return ProductOptionValue::firstOrFactory()->id;
            },
            'price' => $this->faker->randomFloat(2, null, 10000),
            'custom_value' => $this->faker->sentence,
        ];
    }
}
