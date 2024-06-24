<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CreateCategoryRequest;
use Domain\Products\Actions\Categories\UpdateCategoryParent;
use Domain\Products\Models\Category\Category;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryParentControllerTest extends ControllerTestCase
{
    public Category $category;
    public Category $parentCategory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->category = Category::factory()->create();
        $this->parentCategory = Category::factory()->create();
    }

    /** @test */
    public function can_update_parent_category()
    {
        $this->putJson(
            route('admin.parent.category.update', $this->category),
            ['parent_id' => $this->parentCategory->id]
        )
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals($this->parentCategory->id, $this->category->refresh()->parent_id);
    }

    /** @test */
    public function can_get_all_the_category()
    {
        $keyword = "test";
        Category::factory(10)->create(['title' => 'test1']);
        Category::factory(10)->create(['title' => 'test2']);

        $this->getJson(
            route('admin.parent.category.index',['keyword' => $keyword,'category_id'=>$this->category->id]),
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'subtitle',
                    'parent_id'
                ]
            ])->assertJsonCount(20);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->putJson(
            route('admin.parent.category.update', $this->category),
            ['parent_id' => 0]
        )
            ->assertJsonValidationErrorFor('parent_id')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateCategoryParent::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->putJson(
            route('admin.parent.category.update', $this->category),
            ['parent_id' => $this->parentCategory->id]
        )
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals($this->parentCategory->id, $this->category->parent_id);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateCategoryRequest::fake();

        $this->putJson(
            route('admin.parent.category.update', $this->category),
            ['parent_id' => $this->parentCategory->id]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals($this->parentCategory->id, $this->category->parent_id);
    }
}
