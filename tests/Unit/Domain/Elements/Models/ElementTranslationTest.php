<?php

namespace Tests\Unit\Domain\Elements\Models;

use Domain\Content\Models\Element;
use Domain\Content\Models\ElementTranslation;
use Domain\Locales\Models\Language;
use Tests\UnitTestCase;

class ElementTranslationTest extends UnitTestCase
{
    private ElementTranslation $elementTranslation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->elementTranslation = ElementTranslation::factory()->create();
    }

    /** @test */
    public function can_get_element()
    {
        $this->assertInstanceOf(Element::class, $this->elementTranslation->element);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->elementTranslation->language);
    }
}
