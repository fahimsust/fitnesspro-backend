<?php

namespace Database\Factories\Domain\Orders\Models\Checkout;

use Domain\Distributors\Models\Distributor;
use Domain\Orders\Models\Checkout\Checkout;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Checkout\CheckoutShipment>
 */
class CheckoutShipmentFactory extends Factory
{
    protected $model = CheckoutShipment::class;

    public function definition(): array
    {
        return [
            'distributor_id' => Distributor::firstOrFactory(),
            'shipping_method_id' => ShippingMethod::firstOrFactory(),
            'checkout_id' => Checkout::firstOrFactory()
        ];
    }
}
