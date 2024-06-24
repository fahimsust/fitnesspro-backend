<?php

namespace Tests\Unit\Domain\Products\Models\Product\Option;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Option\ProductOptionValueTranslation;
use Tests\UnitTestCase;

class ProductOptionValueTranslationTest extends UnitTestCase
{
    private ProductOptionValueTranslation $productOptionValueTranslation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productOptionValueTranslation = ProductOptionValueTranslation::factory()->create();
    }

    /** @test */
    public function can_get_product_option_value()
    {
        $this->assertInstanceOf(ProductOptionValue::class, $this->productOptionValueTranslation->productOptionValue);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->productOptionValueTranslation->language);
    }
}
