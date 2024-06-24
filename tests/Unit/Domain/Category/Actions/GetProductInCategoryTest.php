<?php

namespace Tests\Unit\Domain\Category\Actions;

use Domain\Products\Actions\Categories\Products\IsProductSetToShowInCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductShow;
use Domain\Products\Models\Product\Product;
use Tests\TestCase;


class GetProductInCategoryTest extends TestCase
{
    /** @test */
    public function can_get_category_product_show()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();
        CategoryProductShow::factory()->create();
        $categoryProductShow = IsProductSetToShowInCategory::run($category, $product->id);
        $this->assertInstanceOf(CategoryProductShow::class,$categoryProductShow);
    }
}
