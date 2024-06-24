<?php

namespace Database\Factories\Domain\Products\Models\Product\Option;

use Domain\Products\Enums\ProductOptionCustomTypes;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionCustom;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionCustomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductOptionCustom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value_id' => ProductOptionValue::firstOrFactory(),
            'custom_type' => $this->faker->randomElement(ProductOptionCustomTypes::cases()),
            'custom_charlimit' => mt_rand(10, 55),
            'custom_label' => $this->faker->word,
            'custom_instruction' => $this->faker->sentence()
        ];
    }
}
