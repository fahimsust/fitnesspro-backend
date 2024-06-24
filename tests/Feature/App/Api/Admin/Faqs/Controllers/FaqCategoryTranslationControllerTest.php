<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqCategoryTranslationRequest;
use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqCategoryTranslation;
use Domain\Locales\Models\Language;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FaqCategoryTranslationControllerTest extends ControllerTestCase
{
    private FaqCategory $faqCategory;
    private Language $language;
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
        $this->faqCategory = FaqCategory::factory()->create();
        $this->language = Language::factory()->create();
    }

    /** @test */
    public function can_create_new_faq_category_translation()
    {
        FaqCategoryTranslationRequest::fake();
        $this->putJson(route('admin.faq-category.translation.update',[$this->faqCategory,$this->language->id]))
            ->assertCreated()
            ->assertJsonStructure(['id','title']);

        $this->assertDatabaseCount(FaqCategoryTranslation::Table(), 1);
    }

    /** @test */
    public function can_update_faq_category_translation()
    {
        FaqCategoryTranslation::factory()->create();
        FaqCategoryTranslationRequest::fake(['title' => 'test title']);

        $this->putJson(route('admin.faq-category.translation.update', [$this->faqCategory,$this->language->id]))
            ->assertCreated();

        $this->assertDatabaseHas(FaqCategoryTranslation::Table(),['title'=>'test title']);
    }
     /** @test */
     public function can_get_faq_category_translation()
     {
        FaqCategoryTranslation::factory()->create();
         $this->getJson(route('admin.faq-category.translation.show', [$this->faqCategory,$this->language->id]))
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
        FaqCategoryTranslationRequest::fake(['title' => 1]);

        $this->putJson(route('admin.faq-category.translation.update',[$this->faqCategory,$this->language->id]))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(FaqCategoryTranslation::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        FaqCategoryTranslationRequest::fake();

        $this->putJson(route('admin.faq-category.translation.update',[$this->faqCategory,$this->language->id]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(FaqCategoryTranslation::Table(), 0);
    }
}
