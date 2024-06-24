<?php

namespace Tests\Unit\Domain\Products\Models\Product;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductTranslation;
use Tests\UnitTestCase;

class ProductTranslationTest extends UnitTestCase
{
    private ProductTranslation $productTranslation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productTranslation = ProductTranslation::factory()->create();
    }

    /** @test */
    public function can_get_product()
    {
        $this->assertInstanceOf(Product::class, $this->productTranslation->product);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->productTranslation->language);
    }
}
