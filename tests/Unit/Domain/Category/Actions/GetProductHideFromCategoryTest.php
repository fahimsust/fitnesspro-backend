<?php

namespace Tests\Unit\Domain\Category\Actions;

use Domain\Products\Actions\Categories\Products\IsProductSetToHideFromCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductHide;
use Domain\Products\Models\Product\Product;
use Tests\TestCase;


class GetProductHideFromCategoryTest extends TestCase
{
    /** @test */
    public function can_get_category_product_show()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        CategoryProductHide::factory()->create();
        $categoryProductHide = IsProductSetToHideFromCategory::run($category, $product->id);
        $this->assertInstanceOf(CategoryProductHide::class,$categoryProductHide);
    }
}
