<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductHide;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryProductHideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryProductHide::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::firstOrFactory(),
            'product_id' => Product::firstOrFactory()
        ];
    }
}
