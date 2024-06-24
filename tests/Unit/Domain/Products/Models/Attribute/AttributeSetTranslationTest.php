<?php

namespace Tests\Unit\Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetTranslation;
use Tests\UnitTestCase;

class AttributeSetTranslationTest extends UnitTestCase
{
    private AttributeSetTranslation $attributeSetTranslation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attributeSetTranslation = AttributeSetTranslation::factory()->create();
    }

    /** @test */
    public function can_get_attribue_set()
    {
        $this->assertInstanceOf(AttributeSet::class, $this->attributeSetTranslation->attributeSet);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->attributeSetTranslation->language);
    }
}
