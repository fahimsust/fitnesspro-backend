<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAvailabilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAvailability::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'display' => $this->faker->word,
            'auto_adjust' => 0
        ];
    }
}
