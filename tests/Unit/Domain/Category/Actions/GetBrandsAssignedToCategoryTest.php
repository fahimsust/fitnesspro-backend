<?php

namespace Tests\Unit\Domain\Category\Actions;

use Domain\Products\Actions\Categories\Brands\GetBrandsAssignedToCategory;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Tests\TestCase;


class GetBrandsAssignedToCategoryTest extends TestCase
{
    /** @test */
    public function can_get_category_brand()
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        CategoryBrand::factory()->create();
        $categoryBrand = GetBrandsAssignedToCategory::run($category, $brand->id);
        $this->assertInstanceOf(CategoryBrand::class,$categoryBrand);
    }
}
