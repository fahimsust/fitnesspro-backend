<?php

namespace Database\Factories\Domain\Orders\Models\Order;

use Domain\Addresses\Models\Address;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Order\Order;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = $this->faker;

        $orderNo = $faker->randomNumber(8);

        return [
            'order_no' => $orderNo,
            'account_id' => null,
            'billing_address_id' => Address::firstOrFactory(),
            'shipping_address_id' => Address::firstOrFactory(),
            'order_phone' => Str::substr($faker->phoneNumber, 0, 15),
            'order_email' => $faker->email,
            'payment_method' => PaymentMethod::firstOrFactory(),
            'addtl_discount' => 0,
            'addtl_fee' => 0,
            'comments' => '',
            'site_id' => Site::firstOrFactory(),
            'cart_id' => Cart::firstOrFactory(),
            'archived' => false, //0=active, 1=archived
            'status' => $faker->randomElement(OrderStatuses::cases()),
            'inventory_order_id' => 0,
        ];
    }
}
