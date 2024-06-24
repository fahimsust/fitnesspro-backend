<?php

namespace Tests\Unit\Domain\Pages\Models;

use Domain\Content\Models\Menus\Menu;
use Domain\Content\Models\Menus\MenusPages;
use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageCategory;
use Domain\Content\Models\Pages\PagesCategories;
use Domain\Content\Models\Pages\PageTranslation;
use Domain\Content\Models\Pages\SitePageSettings;
use Domain\Sites\Models\Site;
use Tests\UnitTestCase;

class PageTest extends UnitTestCase
{
    private Page $page;

    protected function setUp(): void
    {
        parent::setUp();
        $this->page = Page::factory()->create();
        PageTranslation::factory()->create();
        PagesCategories::factory()->create();
        MenusPages::factory()->create();
        SitePageSettings::factory()->create();
    }

    /** @test */
    public function can_get_page_translations()
    {
        $this->assertInstanceOf(PageTranslation::class, $this->page->translations()->first());
    }
    /** @test */
    public function can_get_page_categories()
    {
        $this->assertInstanceOf(PagesCategories::class, $this->page->pagesCategories()->first());
    }
    /** @test */
    public function can_get_category()
    {
        $this->assertInstanceOf(PageCategory::class, $this->page->categories()->first());
    }
    /** @test */
    public function can_get_menu_pages()
    {
        $this->assertInstanceOf(MenusPages::class, $this->page->menusPages()->first());
    }
    /** @test */
    public function can_get_menus()
    {
        $this->assertInstanceOf(Menu::class, $this->page->menus()->first());
    }

    /** @test */
    public function can_get_site_page_setting()
    {
        $this->assertInstanceOf(SitePageSettings::class, $this->page->sitePageSettings()->first());
    }
    /** @test */
    public function can_get_site()
    {
        $this->assertInstanceOf(Site::class, $this->page->siteSettings()->first());
    }
}
