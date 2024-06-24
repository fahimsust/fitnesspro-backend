<?php

namespace Tests\Unit\Domain\Category\Actions;

use Domain\Products\Actions\Categories\FeaturedProducts\IsProductFeaturedInCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Product\Product;
use Tests\TestCase;


class IsFeatureProductInCategoryTest extends TestCase
{
    /** @test */
    public function can_get_category_feature_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        CategoryFeaturedProduct::factory()->create();
        $categoryProductShow = IsProductFeaturedInCategory::run($category, $product->id);
        $this->assertInstanceOf(CategoryFeaturedProduct::class,$categoryProductShow);
    }
}
