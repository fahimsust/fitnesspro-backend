<?php

namespace Database\Factories\Domain\Orders\Models\Checkout;

use Domain\Orders\Models\Checkout\CheckoutPackage;
use Domain\Orders\Models\Checkout\CheckoutShipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Orders\Models\Checkout\CheckoutPackage>
 */
class CheckoutPackageFactory extends Factory
{
    protected $model = CheckoutPackage::class;

    public function definition(): array
    {
        return [
            'shipment_id' => CheckoutShipment::firstOrFactory(),
        ];
    }
}
