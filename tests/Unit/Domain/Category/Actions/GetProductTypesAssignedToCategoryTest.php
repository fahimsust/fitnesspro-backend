<?php

namespace Tests\Unit\Domain\Category\Actions;

use Domain\Products\Actions\Categories\ProductTypes\GetProductTypesAssignedToCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductType;
use Domain\Products\Models\Product\ProductType;
use Tests\TestCase;


class GetProductTypesAssignedToCategoryTest extends TestCase
{
    /** @test */
    public function can_get_category_product_type()
    {
        $category = Category::factory()->create();
        $productType = ProductType::factory()->create();
        CategoryProductType::factory()->create();

        $categoryProductType = GetProductTypesAssignedToCategory::run($category, $productType->id);

        $this->assertInstanceOf(CategoryProductType::class,$categoryProductType);
    }
}
