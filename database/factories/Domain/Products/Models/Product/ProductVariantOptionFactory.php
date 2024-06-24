<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductVariantOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariantOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'option_id' => ProductOptionValue::firstOrFactory(),
        ];
    }
}
