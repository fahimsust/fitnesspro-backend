<?php

namespace Tests\Feature\App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageTranslationMetaDataRequest;
use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PageTranslationMetaDataControllerTest extends ControllerTestCase
{
    private Page $page;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->page = Page::factory()->create();
        $this->language = Language::factory()->create();
        PageTranslation::factory()->create();
    }

    /** @test */
    public function can_update_page_translation_meta()
    {
        PageTranslationMetaDataRequest::fake(['meta_title' => 'test']);

        $this->putJson(route('admin.page.meta-translation.update', [$this->page,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(PageTranslation::Table(),['meta_title'=>'test']);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        PageTranslationMetaDataRequest::fake(['meta_title' => 100]);

        $this->putJson(route('admin.page.meta-translation.update', [$this->page,$this->language->id]))
            ->assertJsonValidationErrorFor('meta_title')
            ->assertStatus(422);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        PageTranslationMetaDataRequest::fake();

        $this->putJson(route('admin.page.meta-translation.update', [$this->page,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
