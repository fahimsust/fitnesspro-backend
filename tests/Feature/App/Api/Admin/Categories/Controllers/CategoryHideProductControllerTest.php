<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Actions\Categories\Products\HideProductFromCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductHide;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryHideProductControllerTest extends ControllerTestCase
{

    public Product $product;
    public Category $category;
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->product = Product::factory()->create();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function can_hide_product_in_category()
    {
        $this->postJson(
            route('admin.category.product.hide.store', $this->category),
            ["product_id" => $this->product->id]
        )
            ->assertCreated()
            ->assertJsonStructure(["*" => ['product_id', 'category_id']]);

        $this->assertDatabaseCount(CategoryProductHide::Table(), 1);
    }

    /** @test */
    public function can_delete_product_from_hide_category()
    {
        CategoryProductHide::factory()->create();

        $this->deleteJson(
            route('admin.category.product.hide.destroy',
            [$this->category, $this->product])
        )
            ->assertOk();

        $this->assertDatabaseCount(CategoryProductHide::Table(), 0);
    }

    /** @test */
    public function can_get_product_hide_in_category()
    {
        CategoryProductHide::factory()->create();
        $this->getJson(route('admin.category.product.hide.index', $this->category))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'title']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.category.product.hide.store', $this->category), ["product_id" => 0])
            ->assertJsonValidationErrorFor('product_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(CategoryProductHide::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(HideProductFromCategory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.category.product.hide.store', $this->category), ["product_id" => $this->product->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(CategoryProductHide::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.category.product.hide.store', $this->category), ["product_id" => $this->product->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CategoryProductHide::Table(), 0);
    }
}
