<?php

namespace Tests\Feature\App\Api\Admin\Faq\Controllers;


use Domain\Content\Models\Faqs\FaqCategory;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FaqCategoryStatusControllerTest extends ControllerTestCase
{
    public FaqCategory $faqCategory;
    protected function setUp(): void
    {
        parent::setUp();
        $this->faqCategory = FaqCategory::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_publish_faq_category()
    {
        $this->faqCategory->update(['status'=>false]);
        $this->postJson(route('admin.faq-category.status', [$this->faqCategory]),['status'=>true])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(true,$this->faqCategory->refresh()->status);
    }
    /** @test */
    public function can_hide_faq_category()
    {
        $this->postJson(route('admin.faq-category.status', [$this->faqCategory]),['status'=>false])
            ->assertCreated()
            ->assertJsonStructure(['id']);
        $this->assertEquals(false,$this->faqCategory->refresh()->status);
    }

     /** @test */
     public function can_validate_request_and_return_errors()
     {
        $this->postJson(route('admin.faq-category.status', [$this->faqCategory]),['status'=>''])
             ->assertJsonValidationErrorFor('status')
             ->assertStatus(422);
     }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.faq-category.status', [$this->faqCategory]),['status'=>false])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
