<?php

namespace Tests\Unit\Domain\Content\Faqs\Models;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqsCategories;
use Domain\Content\Models\Faqs\FaqTranslation;
use Tests\UnitTestCase;

class FaqTest extends UnitTestCase
{
    private Faq $faq;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faq = Faq::factory()->create();

    }

    /** @test */
    public function can_get_faq_translations()
    {
        FaqTranslation::factory()->create();
        $this->assertInstanceOf(FaqTranslation::class, $this->faq->translations()->first());
    }
    /** @test */
    public function can_get_categories()
    {
        FaqsCategories::factory()->create();
        $this->assertInstanceOf(FaqCategory::class, $this->faq->categories()->first());
    }
}
