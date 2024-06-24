<?php

namespace Tests\Unit\Domain\Content\Faqs\Models;

use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqCategoryTranslation;
use Domain\Content\Models\Faqs\FaqsCategories;
use Tests\UnitTestCase;

class FaqCategoryTest extends UnitTestCase
{
    private FaqCategory $faqCategory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faqCategory = FaqCategory::factory()->create();

    }

    /** @test */
    public function can_get_faq_category_translations()
    {
        FaqCategoryTranslation::factory()->create();
        $this->assertInstanceOf(FaqCategoryTranslation::class, $this->faqCategory->translations()->first());
    }
    /** @test */
    public function can_get_faqs()
    {
        FaqsCategories::factory()->create();
        $this->assertInstanceOf(Faq::class, $this->faqCategory->faqs()->first());
    }
}
