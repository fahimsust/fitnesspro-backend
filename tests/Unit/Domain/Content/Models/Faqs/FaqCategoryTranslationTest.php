<?php

namespace Tests\Unit\Domain\Content\Faqs\Models;

use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqCategoryTranslation;
use Domain\Locales\Models\Language;
use Tests\UnitTestCase;

class FaqCategoryTranslationTest extends UnitTestCase
{
    private FaqCategoryTranslation $faqCategoryTranslation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faqCategoryTranslation = FaqCategoryTranslation::factory()->create();
    }

    /** @test */
    public function can_get_faqs()
    {
        $this->assertInstanceOf(FaqCategory::class, $this->faqCategoryTranslation->category);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->faqCategoryTranslation->language);
    }
}
