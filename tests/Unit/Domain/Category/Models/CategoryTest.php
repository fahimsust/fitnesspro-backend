<?php

namespace Tests\Unit\Domain\Category\Models;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Category\CategoryProductHide;
use Domain\Products\Models\Category\CategoryProductShow;
use Domain\Products\Models\Category\CategoryProductType;
use Domain\Products\Models\Category\CategoryTranslation;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Tests\UnitTestCase;

class CategoryTest extends UnitTestCase
{
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();

    }

    /** @test */
    public function can_get_category_translations()
    {
        CategoryTranslation::factory()->create();
        $this->assertInstanceOf(CategoryTranslation::class, $this->category->translations()->first());
    }
    /** @test */
    public function can_get_feature_product()
    {
        CategoryFeaturedProduct::factory()->create();
        $this->assertInstanceOf(Product::class, $this->category->featuredProducts()->first());
    }
    /** @test */
    public function can_get_product_show()
    {
        CategoryProductShow::factory()->create();
        $this->assertInstanceOf(Product::class, $this->category->productsToShow()->first());
    }
    /** @test */
    public function can_get_product_hide()
    {
        CategoryProductHide::factory()->create();
        $this->assertInstanceOf(Product::class, $this->category->productsToHide()->first());
    }
    /** @test */
    public function can_get_brand()
    {
        CategoryBrand::factory()->create();
        $this->assertInstanceOf(Brand::class, $this->category->filteringBrands()->first());
    }
    /** @test */
    public function can_get_product()
    {
        ProductDetail::factory()->create();
        $this->assertInstanceOf(Product::class, $this->category->products()->first());
    }
    /** @test */
    public function can_get_product_type()
    {
        CategoryProductType::factory()->create();
        $this->assertInstanceOf(ProductType::class, $this->category->filteringProductTypes()->first());
    }
}
