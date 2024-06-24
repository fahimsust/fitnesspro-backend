<?php

namespace Tests\Feature\App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageTranslationRequest;
use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PageTranslationControllerTest extends ControllerTestCase
{
    private Page $page;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->page = Page::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_page_translation()
    {
        PageTranslationRequest::fake();
        $this->putJson(route('admin.page.translation.update',[$this->page,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','title']);

        $this->assertDatabaseCount(PageTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_page_translation()
    {
        PageTranslation::factory()->create();
        PageTranslationRequest::fake(['page_content' => 'test content','title'=>'test']);

        $this->putJson(route('admin.page.translation.update', [$this->page,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(PageTranslation::Table(),['content'=>'test content','title'=>'test']);
    }
     /** @test */
     public function can_get_page_translation()
     {
         PageTranslation::factory()->create();
         $this->getJson(route('admin.page.translation.show', [$this->page,$this->language->id]))
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
        PageTranslationRequest::fake(['title' => '']);

        $this->putJson(route('admin.page.translation.update',[$this->page,$this->language->id]))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(PageTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        PageTranslationRequest::fake();

        $this->putJson(route('admin.page.translation.update',[$this->page,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(PageTranslation::Table(), 0);
    }
}
