<?php

namespace Database\Factories\Domain\Products\Models\Product\Option;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductOptionValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'option_id' => ProductOption::firstOrFactory(),
            'name' => $name,
            'display' => $name,
            'price' => 0,
            'rank' => 0,
            'image_id' => null,
            'is_custom' => false,
            'status' => true,
        ];
    }
}
