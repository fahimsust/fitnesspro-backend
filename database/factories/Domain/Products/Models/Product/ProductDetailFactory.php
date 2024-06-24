<?php

namespace Database\Factories\Domain\Products\Models\Product;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class ProductDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = Date::now()->format('Y-m-d');

        return [
            'product_id' => Product::firstOrFactory(),
            'summary' => $this->faker->words(25, true),
            'description' => $this->faker->paragraphs(2, true),
            'product_attributes' => '',
            'type_id' => ProductType::firstOrFactory(),
            'brand_id' => Brand::firstOrFactory(),
            'rating' => $this->faker->randomFloat(1, null, 5),
            'downloadable_file' => '',
            'default_category_id' => Category::firstOrFactory(),
            'views_30days' => 0,
            'views_90days' => 0,
            'views_180days' => 0,
            'views_1year' => 0,
            'views_all' => 0,
            'orders_30days' => 0,
            'orders_90days' => 0,
            'orders_180days' => 0,
            'orders_1year' => 0,
            'orders_all' => 0,
            'downloadable' => false,
            'orders_updated' => $date,
            'views_updated' => $date,
            'create_children_auto' => true,
            'display_children_grid' => false,
            'override_parent_description' => false,
            'allow_pricing_discount' => true,
        ];
    }
}
