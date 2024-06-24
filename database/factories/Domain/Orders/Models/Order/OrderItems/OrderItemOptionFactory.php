<?php

namespace Database\Factories\Domain\Orders\Models\Order\OrderItems;

use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemOption;
use Domain\Orders\Models\Order\OrderItems\OrderItemOptionOld;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItemOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'item_id' => OrderItem::firstOrFactory(),
            'option_value_id' => ProductOptionValue::firstOrFactory(),
        ];
    }
}
