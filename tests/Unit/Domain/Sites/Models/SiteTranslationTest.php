<?php

namespace Tests\Unit\Domain\Sites\Models;

use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteTranslation;
use Tests\UnitTestCase;

class SiteTranslationTest extends UnitTestCase
{
    private SiteTranslation $siteTranslation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->siteTranslation = SiteTranslation::factory()->create();
    }

    /** @test */
    public function can_get_site()
    {
        $this->assertInstanceOf(Site::class, $this->siteTranslation->site);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->siteTranslation->language);
    }
}
