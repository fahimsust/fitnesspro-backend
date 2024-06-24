<?php

namespace Tests\Unit\Domain\Category\Models;

use Domain\Locales\Models\Language;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryTranslation;
use Tests\UnitTestCase;

class CategoryTranslationTest extends UnitTestCase
{
    private CategoryTranslation $categoryTranslation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryTranslation = CategoryTranslation::factory()->create();
    }

    /** @test */
    public function can_get_page()
    {
        $this->assertInstanceOf(Category::class, $this->categoryTranslation->category);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->categoryTranslation->language);
    }
}
