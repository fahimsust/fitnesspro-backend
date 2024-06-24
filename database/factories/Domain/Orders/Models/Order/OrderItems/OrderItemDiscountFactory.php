<?php

namespace Database\Factories\Domain\Orders\Models\Order\OrderItems;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\OrderItems\OrderItemDiscount;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemDiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItemDiscount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'orders_products_id' => OrderItem::firstOrFactory(),
            'discount_id' => Discount::firstOrFactory(),
            'advantage_id' => DiscountAdvantage::firstOrFactory(),
            'amount' => $this->faker->randomDigit,
            'qty' => 1,
        ];
    }
}
