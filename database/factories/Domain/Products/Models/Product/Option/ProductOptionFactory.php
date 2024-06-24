<?php

namespace Database\Factories\Domain\Products\Models\Product\Option;

use Domain\Products\Enums\ProductOptionTypes;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->words(2, true);

        return [
            'name' => $name,
            'display' => $name,
            'type_id' => ProductOptionTypes::Select,
            'product_id' => function () {
                return Product::firstOrFactory()->id;
            },
            'status' => true,
            'show_with_thumbnail' => false,
            'rank' => 0,
            'is_template' => false,
        ];
    }
}
