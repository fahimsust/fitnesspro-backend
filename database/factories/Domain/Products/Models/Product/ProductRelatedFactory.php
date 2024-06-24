<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductRelated;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductRelatedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductRelated::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::firstOrFactory(),
            'related_id' => Product::factory(),
        ];
    }
}
