<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Controllers;

use Domain\Content\Actions\AssignCategoryToFaq;
use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqsCategories;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FaqCategoriesControllerTest extends ControllerTestCase
{
    public Faq $faq;
    public FaqCategory $faqCategory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->faq = Faq::factory()->create();
        $this->faqCategory = FaqCategory::factory()->create();
    }

    /** @test */
    public function can_add_category_in_faq()
    {
        $this->postJson(route('admin.faq.category.store', $this->faq), ["categories_id" => $this->faqCategory->id])
            ->assertCreated()
            ->assertJsonStructure(['categories_id', 'faqs_id']);

        $this->assertDatabaseCount(FaqsCategories::Table(), 1);
    }

    /** @test */
    public function can_delete_category_from_faq()
    {
        FaqsCategories::factory()->create();

        $this->deleteJson(
            route('admin.faq.category.destroy', [$this->faq, $this->faqCategory]),
        )->assertOk()->assertJsonStructure(['title']);

        $this->assertDatabaseCount(FaqsCategories::Table(), 0);
    }

    /** @test */
    public function can_get_category()
    {
        FaqsCategories::factory()->create();
        $this->getJson(route('admin.faq.category.index', $this->faq))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'title']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.faq.category.store', $this->faq), ["categories_id" => 0])
            ->assertJsonValidationErrorFor('categories_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(FaqsCategories::Table(), 0);
    }

    /** @test */
    public function can_handle_erors()
    {
        $this->partialMock(AssignCategoryToFaq::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.faq.category.store', $this->faq), ["categories_id" => $this->faqCategory->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(FaqsCategories::Table(), 0);
    }

    /** @test */
    public function type_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.faq.category.store', $this->faq), ["categories_id" => $this->faqCategory->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(FaqsCategories::Table(), 0);
    }
}
