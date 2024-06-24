<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqTranslationRequest;
use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FaqTranslationControllerTest extends ControllerTestCase
{
    private Faq $faq;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->faq = Faq::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_faq_translation()
    {
        FaqTranslationRequest::fake();
        $this->putJson(route('admin.faq.translation.update',[$this->faq,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','question']);

        $this->assertDatabaseCount(FaqTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_faq_translation()
    {
        FaqTranslation::factory()->create();
        FaqTranslationRequest::fake(['question' => 'test question']);

        $this->putJson(route('admin.faq.translation.update', [$this->faq,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(FaqTranslation::Table(),['question'=>'test question']);
    }
     /** @test */
     public function can_get_faq_translation()
     {
        FaqTranslation::factory()->create();
         $this->getJson(route('admin.faq.translation.show', [$this->faq,$this->language->id]))
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
        FaqTranslationRequest::fake(['question' => 1]);

        $this->putJson(route('admin.faq.translation.update',[$this->faq,$this->language->id]))
            ->assertJsonValidationErrorFor('question')
            ->assertStatus(422);

        $this->assertDatabaseCount(FaqTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        FaqTranslationRequest::fake();

        $this->putJson(route('admin.faq.translation.update',[$this->faq,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(FaqTranslation::Table(), 0);
    }
}
