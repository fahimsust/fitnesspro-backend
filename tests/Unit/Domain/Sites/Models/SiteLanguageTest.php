<?php

namespace Tests\Unit\Domain\Sites\Models;

use Database\Seeders\SiteSeeder;
use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteLanguage;
use Tests\TestCase;

class SiteLanguageTest extends TestCase
{
    protected SiteLanguage $siteLanguage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SiteSeeder::class);

        $this->siteLanguage = SiteLanguage::factory()->create();
    }

    /** @test */
    public function can_get_site()
    {
        $this->assertInstanceOf(Site::class, $this->siteLanguage->site);
    }
    /** @test */
    public function can_get_language()
    {
        $this->assertInstanceOf(Language::class, $this->siteLanguage->language);
    }
}
