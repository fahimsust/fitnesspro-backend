<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Actions\Categories\ProductTypes\AssignProductTypeToCategory;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductType;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryProductTypesControllerTest extends ControllerTestCase
{
    public ProductType $productType;
    public Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->productType = ProductType::factory()->create();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function can_add_product_type_in_category()
    {
        $this->postJson(route('admin.category.product.type.store', $this->category), ["type_id" => $this->productType->id])
            ->assertCreated()
            ->assertJsonStructure(['type_id', 'category_id']);

        $this->assertDatabaseCount(CategoryProductType::Table(), 1);
    }

    /** @test */
    public function can_delete_product_type_from_category()
    {
        CategoryProductType::factory()->create();

        $this->deleteJson(
            route('admin.category.product.type.destroy', [$this->category, $this->productType]),
        )->assertOk()->assertJsonStructure(['name']);;

        $this->assertDatabaseCount(CategoryProductType::Table(), 0);
    }

    /** @test */
    public function can_get_product_type()
    {
        CategoryProductType::factory()->create();
        $this->getJson(route('admin.category.product.type.index', $this->category))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.category.product.type.store', $this->category), ["type_id" => 0])
            ->assertJsonValidationErrorFor('type_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(CategoryProductType::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AssignProductTypeToCategory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.category.product.type.store', $this->category), ["type_id" => $this->productType->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(CategoryProductType::Table(), 0);
    }

    /** @test */
    public function type_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.category.product.type.store', $this->category), ["type_id" => $this->productType->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CategoryProductType::Table(), 0);
    }
}
