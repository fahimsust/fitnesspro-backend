<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryMetaDataRequest;
use Domain\Products\Actions\Categories\UpdateCategoryMetaData;
use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryMetaDataControllerTest extends ControllerTestCase
{
    public Category $category;
    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_category_menu_setting()
    {
        CategoryMetaDataRequest::fake(['meta_title' => 'test']);

        $this->postJson(route('admin.category.meta-data.store', [$this->category]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test', $this->category->refresh()->meta_title);
    }

    /** @test */
    public function can_get_category_menu_setting()
    {
        $this->getJson(route('admin.category.meta-data.index', [$this->category]))
            ->assertOk()
            ->assertJsonStructure([
                'meta_title',
                'meta_desc',
                'meta_keywords'
            ]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CategoryMetaDataRequest::fake(['meta_title' => 100]);

        $this->postJson(route('admin.category.meta-data.store', [$this->category]))
            ->assertJsonValidationErrorFor('meta_title')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateCategoryMetaData::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CategoryMetaDataRequest::fake();

        $this->postJson(route('admin.category.meta-data.store', [$this->category]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CategoryMetaDataRequest::fake();

        $this->postJson(route('admin.category.meta-data.store', [$this->category]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
