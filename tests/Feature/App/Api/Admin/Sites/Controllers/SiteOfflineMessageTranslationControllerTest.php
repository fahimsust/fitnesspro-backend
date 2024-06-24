<?php

namespace Tests\Feature\App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteOfflineMessageTranslationRequest;
use Domain\Locales\Models\Language;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteTranslation;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class SiteOfflineMessageTranslationControllerTest extends ControllerTestCase
{
    private Site $site;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->site = Site::factory()->create();
        $this->language = Language::factory()->create();
        SiteTranslation::factory()->create();
    }

    /** @test */
    public function can_update_page_translation_meta()
    {
        SiteOfflineMessageTranslationRequest::fake(['offline_message' => 'test']);

        $this->putJson(route('admin.site.translation-offline.update', [$this->site,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(SiteTranslation::Table(),['offline_message'=>'test']);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        SiteOfflineMessageTranslationRequest::fake(['offline_message' => 100]);

        $this->putJson(route('admin.site.translation-offline.update', [$this->site,$this->language->id]))
            ->assertJsonValidationErrorFor('offline_message')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        SiteOfflineMessageTranslationRequest::fake();

        $this->putJson(route('admin.site.translation-offline.update', [$this->site,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
