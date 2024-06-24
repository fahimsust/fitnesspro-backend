<?php

namespace Tests\Unit\Domain\Products\Models\Attribute;

use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeTranslation;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Tests\UnitTestCase;

class AttributeTest extends UnitTestCase
{
    private Attribute $attribute;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attribute = Attribute::factory()->create();
    }

    /** @test */
    public function can_get_products()
    {
        ProductAttribute::factory()->create();
        $this->assertInstanceOf(Product::class, $this->attribute->products()->first());
    }
    /** @test */
    public function can_get_translation()
    {
        AttributeTranslation::factory()->create();
        $this->assertInstanceOf(AttributeTranslation::class, $this->attribute->translations()->first());
    }
}
