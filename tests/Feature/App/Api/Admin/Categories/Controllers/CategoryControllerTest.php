<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CreateCategoryRequest;
use Domain\Products\Actions\Categories\CreateCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Category\CategorySiteSettings;
use Domain\Sites\Models\Site;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Site::factory(5)->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_category()
    {
        CreateCategoryRequest::fake();

        $response = $this->postJson(route('admin.category.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(Category::Table(), 2);
        $this->assertDatabaseCount(CategorySiteSettings::Table(), 6);
        $this->assertDatabaseHas(Category::Table(), ['id' => $response['id']]);
    }

    /** @test */
    public function can_update_category()
    {
        $category = Category::factory()->create();
        CreateCategoryRequest::fake(['title' => 'test']);

        $response = $this->putJson(route('admin.category.update', [$category]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals($category->refresh()->title, $response['title']);
    }

    /** @test */
    public function can_delete_category()
    {
        $category = Category::factory(5)->create();

        CategoryBrand::factory()->create();
        CategoryFeaturedProduct::factory()->create();
        $child = Category::factory()->create(['parent_id'=>$category->first()->id]);
        CategoryBrand::factory()->create(['category_id'=>$child->id]);

        $this->deleteJson(route('admin.category.destroy', [$category->first()]))
            ->assertOk();

        $this->assertDatabaseCount(Category::Table(), 4);

        //checking cascade delete is working
        $this->assertDatabaseCount(CategoryBrand::Table(), 0);
        $this->assertDatabaseCount(CategoryFeaturedProduct::Table(), 0);
    }

    /** @test */
    public function can_get_all_the_category()
    {
        Category::factory(30)->create();

        $response = $this->getJson(route('admin.category.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(30);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $data = CreateCategoryRequest::factory()->create(['title' => '']);

        $this->postJson(route('admin.category.store'), $data)
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(Category::Table(), 1);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateCategory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CreateCategoryRequest::fake();

        $this->postJson(route('admin.category.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Category::Table(), 1);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateCategoryRequest::fake();

        $this->postJson(route('admin.category.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Category::Table(), 1);
    }
}
