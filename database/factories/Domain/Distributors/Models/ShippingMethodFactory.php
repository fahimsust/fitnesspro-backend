<?php

namespace Database\Factories\Domain\Distributors\Models;

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
        $name = $this->faker->words(2, true);
        $refname = $this->faker->word.'-'.$this->faker->randomDigit;

        return [
            'name' => $name,
            'display' => $name,
            'refname' => $refname,
            'carriercode' => $refname,
            'status' => true,
            'price' => 0,
            'rank' => 0,
            'ships_residential' => 0,
            'carrier_id' => 0,
            'weight_limit' => 0,
            'weight_min' => 0,
            'is_international' => 0,
        ];
    }
}
