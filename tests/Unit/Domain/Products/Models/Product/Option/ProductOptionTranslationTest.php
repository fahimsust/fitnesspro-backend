<?php

namespace Tests\Unit\Domain\Products\Models\Product\Option;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionTranslation;
use Tests\UnitTestCase;

class ProductOptionTranslationTest extends UnitTestCase
{
    private ProductOptionTranslation $productOptionTranslation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productOptionTranslation = ProductOptionTranslation::factory()->create();
    }

    /** @test */
    public function can_get_product_option()
    {
        $this->assertInstanceOf(ProductOption::class, $this->productOptionTranslation->productOption);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->productOptionTranslation->language);
    }
}
