<?php

namespace Database\Factories\Domain\Orders\Models\Shipping;

use Domain\Orders\Models\Shipping\ShippingCarrier;
use Domain\Orders\Models\Shipping\ShippingGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingCarrierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShippingCarrier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gateway_id' => ShippingGateway::firstOrFactory(),
            'name' => $this->faker->name,
            'classname' => $this->faker->name,
            'table' => $this->faker->name,
            'carrier_code' => $this->faker->name,
            'status' => true,
            'limit_shipto' => 0,
        ];
    }
}
