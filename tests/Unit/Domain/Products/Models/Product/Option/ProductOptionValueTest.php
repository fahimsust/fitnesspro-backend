<?php

namespace Tests\Unit\Domain\Products\Models\Product\Option;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductVariantOption;
use Tests\UnitTestCase;

class ProductOptionValueTest extends UnitTestCase
{
    private ProductOptionValue $productOptionValue;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productOptionValue = ProductOptionValue::factory()->create();
    }

    /** @test */
    public function can_get_translations()
    {
        ProductOptionValueTranslation::factory()->create();
        $this->assertInstanceOf(ProductOptionValueTranslation::class, $this->productOptionValue->translations()->first());
    }
    /** @test */
    public function can_get_product()
    {
        ProductVariantOption::factory()->create();
        $this->assertInstanceOf(Product::class, $this->productOptionValue->variants()->first());
    }
}
