<?php

namespace Database\Factories\Domain\Orders\Models\Checkout;

use Domain\Addresses\Models\Address;
use Domain\Orders\Enums\Checkout\CheckoutStatuses;
use Domain\Orders\Models\Carts\Cart;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Checkout\Checkout>
 */
class CheckoutFactory extends Factory
{
    protected $model = Checkout::class;

    public function definition(): array
    {
        $cart = Cart::firstOrFactory();

        return [
            'uuid' => $this->faker->uuid,
            'cart_id' => $cart,
            'site_id' => $cart->site,
            'account_id' => null,
            'billing_address_id' => null,
            'shipping_address_id' => null,
            'status' => CheckoutStatuses::Init,
        ];
    }

    public function withAccount(): self
    {
        return $this->state(
            fn(array $attributes) => [
                'account_id' => $attributes['cart_id']->account,
            ]
        );
    }

    public function withAddresses(): self
    {
        return $this->state(
            fn(array $attributes) => [
                'billing_address_id' => Address::firstOrFactory(),
                'shipping_address_id' => Address::firstOrFactory(),
            ]
        );
    }

    public function withBillingAddress(): self
    {
        return $this->state(
            fn(array $attributes) => [
                'billing_address_id' => Address::firstOrFactory(),
            ]
        );
    }

    public function withShippingAddress(): self
    {
        return $this->state(
            fn(array $attributes) => [
                'shipping_address_id' => Address::firstOrFactory(),
            ]
        );
    }

    public function withOrder(): self
    {
        return $this->state(
            fn(array $attributes) => [
                'order_id' => Order::firstOrFactory(),
            ]
        );
    }
}
