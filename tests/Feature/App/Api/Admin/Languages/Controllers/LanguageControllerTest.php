<?php

namespace Tests\Feature\App\Api\Admin\Languages\Controllers;

use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteLanguage;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class LanguageControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }


    /** @test */
    public function can_get_languages_list()
    {
        Language::factory(30)->create();

        $this->getJson(route('admin.languages.index'))
            ->assertOk()
            ->assertJsonStructure([ '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(30);
    }
    /** @test */
    public function can_search_language_for_site()
    {
        $site = Site::factory()->create();
        $languages = Language::factory(10)->create();
        SiteLanguage::factory()->create(['language_id' => $languages[0]->id,'site_id'=>$site->id]);
        SiteLanguage::factory()->create(['language_id' => $languages[1]->id,'site_id'=>$site->id]);
        SiteLanguage::factory()->create(['language_id' => $languages[2]->id,'site_id'=>$site->id]);
        $this->getJson(
            route('admin.languages.index', ['site_id' => $site->id]),
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])->assertJsonCount(7);
    }
}
