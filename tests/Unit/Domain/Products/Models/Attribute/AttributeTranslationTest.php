<?php

namespace Tests\Unit\Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeTranslation;
use Tests\UnitTestCase;

class AttributeTranslationTest extends UnitTestCase
{
    private AttributeTranslation $attributeTranslation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attributeTranslation = AttributeTranslation::factory()->create();
    }

    /** @test */
    public function can_get_attribue()
    {
        $this->assertInstanceOf(Attribute::class, $this->attributeTranslation->attribute);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->attributeTranslation->language);
    }
}
