<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAccessoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAccessory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'accessory_id' => Product::factory(),
            'required' => $this->faker->boolean,
            'show_as_option' => $this->faker->boolean,
            'discount_percentage' => $this->faker->numberBetween(0,100),
            'required' => $this->faker->boolean,
            'description' => $this->faker->word(2),
        ];
    }
}
