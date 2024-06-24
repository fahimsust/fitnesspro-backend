<?php

namespace Tests\Unit\Domain\Products\Models\Attribute;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeOptionTranslation;
use Tests\UnitTestCase;

class AttributeOptionTranslationTest extends UnitTestCase
{
    private AttributeOptionTranslation $attributeOptionTranslation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->attributeOptionTranslation = AttributeOptionTranslation::factory()->create();
    }

    /** @test */
    public function can_get_attribue_option()
    {
        $this->assertInstanceOf(AttributeOption::class, $this->attributeOptionTranslation->option);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->attributeOptionTranslation->language);
    }
}
