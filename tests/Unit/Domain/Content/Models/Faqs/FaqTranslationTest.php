<?php

namespace Tests\Unit\Domain\Content\Faqs\Models;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqTranslation;
use Domain\Locales\Models\Language;
use Tests\UnitTestCase;

class FaqTranslationTest extends UnitTestCase
{
    private FaqTranslation $faqTranslation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faqTranslation = FaqTranslation::factory()->create();
    }

    /** @test */
    public function can_get_page()
    {
        $this->assertInstanceOf(Faq::class, $this->faqTranslation->faq);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->faqTranslation->language);
    }
}
