<?php

namespace Tests\Feature\App\Api\Admin\Brands\Controllers;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryBrand;
use Domain\Products\Models\Product\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class BrandControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_brand()
    {
        $this->postJson(route('admin.brand.store'),['name'=>'test'])
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(Brand::Table(), 1);
    }
    /** @test */
    public function can_get_brands_all_brand()
    {
        Brand::factory(100)->create();

        $this->getJson(route('admin.brand.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(100);
    }

    /** @test */
    public function can_update_brand()
    {
        $brand = Brand::factory()->create();

        $this->putJson(route('admin.brand.update', [$brand]), ['name' => 'test'])
            ->assertCreated();

        $this->assertEquals('test', $brand->refresh()->name);
    }

    /** @test */
    public function can_delete_brand()
    {
        $brand = Brand::factory(5)->create();
        $category = Category::factory()->create();
        CategoryBrand::factory()->create(['brand_id' => $brand->first()->id, 'category_id' => $category->id]);
        CategoryBrand::factory()->create(['brand_id' => $brand[1]->id, 'category_id' => $category->id]);

        $this->deleteJson(route('admin.brand.destroy', [$brand->first()]))
            ->assertOk();

        $this->assertDatabaseCount(Brand::Table(), 4);
        $this->assertDatabaseCount(CategoryBrand::Table(), 1);
    }

    /** @test */
    public function can_get_exception_for_product_exists()
    {
        $brand = Brand::factory(5)->create();
        ProductDetail::factory()->create(['brand_id' => $brand->first()->id]);

        $this->withoutExceptionHandling()
            ->expectExceptionCode(Response::HTTP_PRECONDITION_FAILED);

        $this->deleteJson(route('admin.brand.destroy', [$brand->first()]));
    }

    /** @test */
    public function can_get_exception_for_category_exists()
    {
        $brand = Brand::factory(5)->create();
        $category = Category::factory(5)->create();
        CategoryBrand::factory()->create(['brand_id' => $brand->first()->id, 'category_id' => $category->first()->id]);
        CategoryBrand::factory()->create(['brand_id' => $brand->first()->id, 'category_id' => $category[1]->id]);
        CategoryBrand::factory()->create(['brand_id' => $brand[1]->id, 'category_id' => $category[1]->id]);

        $this->withoutExceptionHandling()
            ->expectExceptionCode(Response::HTTP_CONFLICT);

        $this->deleteJson(route('admin.brand.destroy', [$brand->first()]));
    }

    /** @test */
    public function can_get_brands_list()
    {
        Brand::factory(30)->create();

        $response = $this->getJson(route('admin.brands.list', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])
            ->assertJsonCount(5, 'data');
        $this->assertEquals(2, $response['current_page']);
    }

    /** @test */
    public function can_search_brands()
    {
        Brand::factory()->create(['name' => 'test1']);
        Brand::factory()->create(['name' => 'test2']);
        Brand::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.brands.list', ["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(2, 'data');
    }
    /** @test */
    public function can_search_product_for_brand_category()
    {
        $category = Category::factory()->create();
        $brands = Brand::factory(10)->create();
        CategoryBrand::factory()->create(['brand_id' => $brands[0]->id,'category_id'=>$category->id]);
        CategoryBrand::factory()->create(['brand_id' => $brands[1]->id,'category_id'=>$category->id]);
        CategoryBrand::factory()->create(['brand_id' => $brands[2]->id,'category_id'=>$category->id]);
        $this->getJson(
            route('admin.brands.list', ['category_id' => $category->id]),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]])->assertJsonCount(7, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.brand.store'), ['name' => ''])
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(Brand::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.brand.store'), ['name' => 'test'])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Brand::Table(), 0);
    }
}
