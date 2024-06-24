<?php

namespace Database\Factories\Domain\Orders\Models\Shipping;

use Domain\Orders\Models\Shipping\ShippingGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingGatewayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShippingGateway::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'classname' => $this->faker->name,
            'table' => $this->faker->name,
            'status' => true,
        ];
    }
}
