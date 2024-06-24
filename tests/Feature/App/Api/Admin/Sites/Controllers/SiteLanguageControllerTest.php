<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use Domain\Locales\Models\Language;
use Domain\Sites\Actions\Languages\ActivateLanguageForSite;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteLanguage;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteLanguageControllerTest extends ControllerTestCase
{

    public Language $language;
    public Site $site;
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->language = Language::factory()->create();
        $this->site = Site::factory()->create();
    }

    /** @test */
    public function can_add_language_in_site()
    {
        $this->postJson(route('admin.site.language.store', $this->site), ["language_id" => $this->language->id])
            ->assertCreated()
            ->assertJsonStructure(['language_id', 'site_id']);

        $this->assertDatabaseCount(SiteLanguage::Table(), 1);
    }
    /** @test */
    public function can_update_rank()
    {
        $siteLanguage = SiteLanguage::factory()->create();
        $this->putJson(
            route('admin.site.language.update', [$this->site, $this->language]),
            ["rank" => 5]
        )
            ->assertCreated();

        $this->assertEquals(5, $siteLanguage->refresh()->rank);
    }

    /** @test */
    public function can_delete_language_from_site()
    {
        SiteLanguage::factory()->create();

        $this->deleteJson(
            route('admin.site.language.destroy', [$this->site, $this->language]),
        )->assertOk();

        $this->assertDatabaseCount(SiteLanguage::Table(), 0);
    }

    /** @test */
    public function can_get_language_in_site()
    {
        SiteLanguage::factory()->create();

        $this->getJson(route('admin.site.language.index', $this->site))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.site.language.store', $this->site), ["language_id" => 0])
            ->assertJsonValidationErrorFor('language_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(SiteLanguage::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(ActivateLanguageForSite::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.site.language.store', $this->site), ["language_id" => $this->language->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(SiteLanguage::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.site.language.store', $this->site), ["language_id" => $this->language->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(SiteLanguage::Table(), 0);
    }
}
