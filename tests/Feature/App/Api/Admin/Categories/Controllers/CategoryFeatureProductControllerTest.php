<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Actions\Categories\FeaturedProducts\FeatureProductInCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryFeaturedProduct;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryFeatureProductControllerTest extends ControllerTestCase
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
        $this->postJson(route('admin.category.product.featured.store', $this->category), ["product_id" => $this->product->id])
            ->assertCreated()
            ->assertJsonStructure(['product_id', 'category_id']);

        $this->assertDatabaseCount(CategoryFeaturedProduct::Table(), 1);
    }
    /** @test */
    public function can_update_rank()
    {
        $categoryFeaturedProduct = CategoryFeaturedProduct::factory()->create();
        $this->putJson(
            route('admin.category.product.featured.update', [$this->category, $this->product]),
            ["rank" => 5]
        )
            ->assertCreated();

        $this->assertEquals(5, $categoryFeaturedProduct->refresh()->rank);
    }

    /** @test */
    public function can_delete_product_from_category()
    {
        CategoryFeaturedProduct::factory()->create();

        $this->deleteJson(
            route('admin.category.product.featured.destroy', [$this->category, $this->product]),
        )->assertOk()->assertJsonStructure(['title']);;

        $this->assertDatabaseCount(CategoryFeaturedProduct::Table(), 0);
    }

    /** @test */
    public function can_get_product_in_category()
    {
        CategoryFeaturedProduct::factory()->create();

        $this->getJson(route('admin.category.product.featured.index', $this->category))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'title']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.category.product.featured.store', $this->category), ["product_id" => 0])
            ->assertJsonValidationErrorFor('product_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(CategoryFeaturedProduct::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(FeatureProductInCategory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.category.product.featured.store', $this->category), ["product_id" => $this->product->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(CategoryFeaturedProduct::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.category.product.featured.store', $this->category), ["product_id" => $this->product->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CategoryFeaturedProduct::Table(), 0);
    }
}
