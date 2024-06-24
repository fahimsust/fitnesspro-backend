<?php

namespace Database\Factories\Domain\Distributors\Models\Shipping;

use Domain\Addresses\Models\Address;
use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\Shipping\DistributorShippingGateway;
use Domain\Orders\Models\Shipping\ShippingGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistributorShippingGatewayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DistributorShippingGateway::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'distributor_id' => Distributor::firstOrFactory(),
            'shipping_gateway_id' => ShippingGateway::firstOrFactory(),
            'address_id' => Address::firstOrFactory()
        ];
    }
}
