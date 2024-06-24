<?php

namespace Database\Factories\Domain\Products\Models\Product\Option;

use Domain\Messaging\Models\MessageTemplate;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemSentEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderProductSentEmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItemSentEmail::class;

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
            'email_id' => function () {
                return MessageTemplate::firstOrFactory()->id;
            },
        ];
    }
}
