<?php

namespace Tests\RequestFactories\App\Api\Admin\Products\Requests;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Product\ProductType;
use Worksome\RequestFactories\RequestFactory;

class UpdateProductDetailsRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'brand_id' => Brand::firstOrFactory()->id,
            'downloadable_file' => $this->faker->word,
            'downloadable' => $this->faker->boolean,
            'default_category_id' => Category::firstOrFactory()->id,
            'create_children_auto' => $this->faker->boolean,
            'display_children_grid' => $this->faker->boolean,
            'override_parent_description' => $this->faker->boolean,
            'allow_pricing_discount' => $this->faker->boolean,
        ];
    }
}
