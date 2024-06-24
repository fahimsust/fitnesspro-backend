<?php

namespace Tests\Unit\Domain\Products\Models\Attribute;

use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetAttribute;
use Domain\Products\Models\Attribute\AttributeSetTranslation;
use Domain\Products\Models\Attribute\AttributeTranslation;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Tests\UnitTestCase;

class AttributeSetTest extends UnitTestCase
{
    private AttributeSet $attributeSet;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attributeSet = AttributeSet::factory()->create();
    }

    /** @test */
    public function can_get_products()
    {
        AttributeSetAttribute::factory()->create();
        ProductAttribute::factory()->create();
        $this->assertInstanceOf(Product::class, $this->attributeSet->products()->first());
    }
    /** @test */
    public function can_get_translation()
    {
        AttributeSetTranslation::factory()->create();
        $this->assertInstanceOf(AttributeSetTranslation::class, $this->attributeSet->translations()->first());
    }
}
