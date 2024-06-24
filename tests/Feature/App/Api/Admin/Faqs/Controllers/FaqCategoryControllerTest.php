<?php

namespace Tests\Feature\App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqCategoryRequest;
use Domain\Content\Models\Faqs\FaqCategory;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class FaqCategoryControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_faq_category()
    {
        FaqCategoryRequest::fake();

        $this->postJson(route('admin.faq-category.store'))
            ->assertCreated()
            ->assertJsonStructure(['id','title']);

        $this->assertDatabaseCount(FaqCategory::Table(), 1);
    }

    /** @test */
    public function can_update_faq_category()
    {
        $faq_category = FaqCategory::factory()->create();
        FaqCategoryRequest::fake(['title' => 'test title']);

        $this->putJson(route('admin.faq-category.update', [$faq_category]))
            ->assertCreated();

        $this->assertDatabaseHas(FaqCategory::Table(),['title' => 'test title']);
    }

    /** @test */
    public function can_delete_faq_category()
    {
        $faq_category = FaqCategory::factory(5)->create();
        $this->deleteJson(route('admin.faq-category.destroy', [$faq_category->first()]))
            ->assertOk();

        $this->assertDatabaseCount(FaqCategory::Table(), 4);
    }

    /** @test */
    public function can_get_faq_category_list()
    {
        FaqCategory::factory(30)->create();

        $response = $this->getJson(route('admin.faq-category.index', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'status',
                    'rank'
                ]
            ]]);

        $this->assertEquals(5, count($response['data']));
        $this->assertEquals(2, $response['current_page']);
    }
    /** @test */
    public function can_search_faq_category()
    {
        FaqCategory::factory()->create(['title' => 'test1']);
        FaqCategory::factory()->create(['title' => 'test2']);
        FaqCategory::factory()->create(['title' => 'not_match']);

        $this->getJson(
            route('admin.faq-category.index',["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'status',
                    'rank'
                ]
            ]])->assertJsonCount(2,'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        FaqCategoryRequest::fake(['title' => '']);

        $this->postJson(route('admin.faq-category.store'))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(FaqCategory::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        FaqCategoryRequest::fake();

        $this->postJson(route('admin.faq-category.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(FaqCategory::Table(), 0);
    }
}
