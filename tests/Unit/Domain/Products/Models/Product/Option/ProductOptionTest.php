<?php

namespace Tests\Unit\Domain\Products\Models\Product\Option;

use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Tests\UnitTestCase;

class ProductOptionTest extends UnitTestCase
{
    private ProductOption $productOption;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productOption = ProductOption::factory()->create();
    }

    /** @test */
    public function can_get_translations()
    {
        ProductOptionTranslation::factory()->create();
        $this->assertInstanceOf(ProductOptionTranslation::class, $this->productOption->translations()->first());
    }
    /** @test */
    public function can_get_product_option_value()
    {
        ProductOptionValue::factory()->create();
        $this->assertInstanceOf(ProductOptionValue::class, $this->productOption->optionValues()->first());
    }
}
