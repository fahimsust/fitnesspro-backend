<?php

namespace Tests\Feature\App\Api\Admin\Categories\Controllers;

use Domain\Products\Actions\Categories\Brands\AssignBrandToCategory;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class CategoryBrandsControllerTest extends ControllerTestCase
{
    public Brand $brand;
    public Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->brand = Brand::factory()->create();
        $this->category = Category::factory()->create();
    }

    /** @test */
    public function can_add_brand_in_category()
    {
        $this->postJson(route('admin.category.brand.store', $this->category), ["brand_id" => $this->brand->id])
            ->assertCreated()
            ->assertJsonStructure(['brand_id', 'category_id']);

        $this->assertDatabaseCount(CategoryBrand::Table(), 1);
    }

    /** @test */
    public function can_delete_brand_from_category()
    {
        CategoryBrand::factory()->create();

        $this->deleteJson(
            route('admin.category.brand.destroy', [$this->category, $this->brand]),
        )->assertOk()->assertJsonStructure(['name']);

        $this->assertDatabaseCount(CategoryBrand::Table(), 0);
    }

    /** @test */
    public function can_get_brand()
    {
        CategoryBrand::factory()->create();
        $this->getJson(route('admin.category.brand.index', $this->category))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name']]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.category.brand.store', $this->category), ["brand_id" => 0])
            ->assertJsonValidationErrorFor('brand_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(CategoryBrand::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AssignBrandToCategory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.category.brand.store', $this->category), ["brand_id" => $this->brand->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(CategoryBrand::Table(), 0);
    }

    /** @test */
    public function type_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.category.brand.store', $this->category), ["brand_id" => $this->brand->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(CategoryBrand::Table(), 0);
    }
}
