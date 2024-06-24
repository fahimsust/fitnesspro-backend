<?php

namespace Database\Factories\Domain\Distributors\Models\Shipping;

use Domain\Distributors\Models\Distributor;
use Domain\Distributors\Models\Shipping\DistributorShippingMethod;
use Domain\Orders\Models\Shipping\ShippingMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class DistributorShippingMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DistributorShippingMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'distributor_id' => Distributor::firstOrFactory(),
            'shipping_method_id' => ShippingMethod::firstOrFactory(),
            'status' => true,
            'flat_price' => $this->faker->randomFloat(2, 0, 100),
            'flat_use' => false,
            'handling_fee' => 0,
            'handling_percentage' => $this->faker->randomFloat(2, 0, 100),
            'call_for_estimate' => false,
            'discount_rate' => 0,
            'display' => $this->faker->word,
            'override_is_international' => $this->faker->boolean,
        ];
    }
}
