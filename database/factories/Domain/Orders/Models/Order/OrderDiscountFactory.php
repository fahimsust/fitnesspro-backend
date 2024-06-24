<?php

namespace Database\Factories\Domain\Orders\Models\Order;

use Domain\Discounts\Models\Advantage\DiscountAdvantage;
use Domain\Discounts\Models\Discount;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderDiscount;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDiscountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderDiscount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::firstOrFactory(),
            'discount_id' => Discount::firstOrFactory(),
            'advantage_id' => DiscountAdvantage::firstOrFactory()
        ];
    }
}
