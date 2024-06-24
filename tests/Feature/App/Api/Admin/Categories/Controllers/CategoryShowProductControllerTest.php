<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Actions\Categories\Products\ShowProductInCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductShow;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryShowProductControllerTest extends ControllerTestCase
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
    public function can_add_product_in_category()
    {
        $this->postJson(route('admin.category.product.show.store', $this->category), ["product_id" => $this->product->id])
            ->assertCreated()
            ->assertJsonStructure(["*" => ['product_id', 'category_id']]);

        $this->assertDatabaseCount(CategoryProductShow::Table(), 1);
    }

    /** @test */
    public function can_update_rank()
    {
        $catProductShow = CategoryProductShow::factory()->create();
        $this->putJson(
            route('admin.category.product.show.update', [$this->category, $this->product]),
            ["rank" => 5]
        )
            ->assertCreated();

        $this->assertEquals(5, $catProductShow->refresh()->rank);
    }

    /** @test */
    public function can_delete_product_from_category()
    {
        CategoryProductShow::factory()->create();

        $this->deleteJson(
            route('admin.category.product.show.destroy', [$this->category, $this->product]),
        )
            ->assertOk();

        $this->assertDatabaseCount(CategoryProductShow::Table(), 0);
    }

    /** @test */
    public function can_get_product_in_category()
    {
        CategoryProductShow::factory()->create();
        $this->getJson(route('admin.category.product.show.index', $this->category))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'title']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.category.product.show.store', $this->category), ["product_id" => 0])
            ->assertJsonValidationErrorFor('product_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(CategoryProductShow::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(ShowProductInCategory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.category.product.show.store', $this->category), ["product_id" => $this->product->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(CategoryProductShow::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.category.product.show.store', $this->category), ["product_id" => $this->product->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CategoryProductShow::Table(), 0);
    }
}
