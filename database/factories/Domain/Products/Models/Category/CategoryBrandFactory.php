<?php

namespace Database\Factories\Domain\Products\Models\Category;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryBrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryBrand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::firstOrFactory(),
            'brand_id' => Brand::firstOrFactory()
        ];
    }
}
