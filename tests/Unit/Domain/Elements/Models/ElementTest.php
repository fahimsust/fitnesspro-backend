<?php

namespace Tests\Unit\Domain\Elements\Models;

use Domain\Content\Models\Element;
use Domain\Content\Models\ElementTranslation;
use Tests\UnitTestCase;

class ElementTest extends UnitTestCase
{
    private Element $element;

    protected function setUp(): void
    {
        parent::setUp();
        $this->element = Element::factory()->create();
        ElementTranslation::factory()->create();
    }

    /** @test */
    public function can_get_element_translations()
    {
        $this->assertInstanceOf(ElementTranslation::class, $this->element->translations()->first());
    }
}
