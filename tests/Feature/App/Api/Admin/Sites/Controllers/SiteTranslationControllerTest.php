<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteTranslationControllerTest extends ControllerTestCase
{
    private Site $site;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->site = Site::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_site_translation()
    {
        SiteTranslationRequest::fake();
        $this->putJson(route('admin.site.translation.update',[$this->site,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','meta_title']);

        $this->assertDatabaseCount(SiteTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_site_translation()
    {
        SiteTranslation::factory()->create();
        SiteTranslationRequest::fake(['meta_title' => 'test title']);

        $this->putJson(route('admin.site.translation.update', [$this->site,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(SiteTranslation::Table(),['meta_title'=>'test title']);
    }
     /** @test */
     public function can_get_site_translation()
     {
         SiteTranslation::factory()->create();
         $this->getJson(route('admin.site.translation.show', [$this->site,$this->language->id]))
             ->assertOk()
             ->assertJsonStructure(
                 [
                     'id',
                 ]
             );
     }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        SiteTranslationRequest::fake(['meta_title' => '']);

        $this->putJson(route('admin.site.translation.update',[$this->site,$this->language->id]))
            ->assertJsonValidationErrorFor('meta_title')
            ->assertStatus(422);

        $this->assertDatabaseCount(SiteTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        SiteTranslationRequest::fake();

        $this->putJson(route('admin.site.translation.update',[$this->site,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(SiteTranslation::Table(), 0);
    }
}
