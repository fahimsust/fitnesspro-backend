<?php

namespace Tests\Unit\Domain\Pages\Models;

use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageTranslation;
use Domain\Locales\Models\Language;
use Tests\UnitTestCase;

class PageTranslationTest extends UnitTestCase
{
    private PageTranslation $pageTranslation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pageTranslation = PageTranslation::factory()->create();
    }

    /** @test */
    public function can_get_page()
    {
        $this->assertInstanceOf(Page::class, $this->pageTranslation->page);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->pageTranslation->language);
    }
}
