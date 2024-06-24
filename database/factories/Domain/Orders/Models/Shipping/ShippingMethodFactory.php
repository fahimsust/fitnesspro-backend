<?php

namespace Database\Factories\Domain\Orders\Models\Shipping;

use Domain\Orders\Models\Shipping\ShippingCarrier;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShippingMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'display' => $this->faker->name,
            'refname' => $this->faker->name,
            'carriercode' => $this->faker->name,
            'status' => true,
            'price' => $this->faker->randomFloat(2, 1, 999),
            'ships_residential' => 0,
            'carrier_id' => ShippingCarrier::firstOrFactory(),
            'weight_limit' => 0,
            'weight_min' => 0,
        ];
    }
}
