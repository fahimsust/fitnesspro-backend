<?php

namespace Tests\Feature\App\Api\Admin\ProductOptions\Controllers;

use App\Api\Admin\ProductOptions\Requests\CreateProductOptionRequest;
use App\Api\Admin\ProductOptions\Requests\UpdateProductOptionRequest;
use Domain\Products\Models\Product\Option\ProductOption;
use Domain\Products\Models\Product\Option\ProductOptionValue;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductVariantOption;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductOptionControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_product_option()
    {
        CreateProductOptionRequest::fake();
        $this->postJson(route('admin.product-option.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ProductOption::Table(), 1);
    }

    /** @test */
    public function can_update_product_option()
    {
        $productOption = ProductOption::factory()->create();
        UpdateProductOptionRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.product-option.update', [$productOption]))
            ->assertCreated();

        $this->assertEquals('test', $productOption->refresh()->name);
    }

    /** @test */
    public function can_search_product_option_by_product_id()
    {
        $product = Product::factory()->create();
        ProductOption::factory()->create(['name' => 'test1']);
        ProductOption::factory()->create(['name' => 'test2']);
        ProductOption::factory()->create(['name' => 'not_match']);

        $this->getJson(route('admin.product-option.index', ['product_id' => $product->id, 'keyword' => 'test']),)
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'display',
                    'option_type',
                    'rank'
                ]
            ]])
            ->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_get_all_the_product_option_by_product_id()
    {
        $products = Product::factory(2)->create();
        ProductOption::factory(15)->create(['product_id' => $products->first()->id]);
        ProductOption::factory(5)->create(['product_id' => $products[1]->id]);

        $this->getJson(route('admin.product-option.index', ['product_id' => $products->first()->id]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'display',
                    'rank'
                ]
            ]])
            ->assertJsonCount(15, 'data');
    }

    /** @test */
    public function can_delete_product_option()
    {
        $productOption = ProductOption::factory()->create();

        $this->deleteJson(route('admin.product-option.destroy', [$productOption]))
            ->assertOk();

        $this->assertDatabaseCount(ProductOption::Table(), 0);
    }

    /** @test */
    public function can_get_exception_for_product_exists()
    {
        $productOption = ProductOption::factory()->create();
        $productOptionValue = ProductOptionValue::factory()->create(['option_id' => $productOption->id]);
        ProductVariantOption::factory()->create(['option_id' => $productOptionValue->id]);

        $response = $this->deleteJson(route('admin.product-option.destroy', [$productOption]))
            ->assertStatus(500);

        $this->assertStringContainsString('option', $response['message']);

        $this->assertDatabaseCount(ProductOption::Table(), 1);
    }


    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CreateProductOptionRequest::fake(['product_id' => 10000]);
        $this->postJson(route('admin.product-option.store'))
            ->assertJsonValidationErrorFor('product_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOption::Table(), 0);
    }

    /** @test */
    public function can_validate_product_option_is_child()
    {
        $parent_product = Product::factory()->create();
        $child_product = Product::factory()->create(['parent_product' => $parent_product->id]);
        CreateProductOptionRequest::fake(['product_id' => $child_product->id]);

        $this->postJson(route('admin.product-option.store'))
            ->assertJsonValidationErrorFor('product_id')
            ->assertJsonFragment(["message" => __("Can't create options on a child product")])
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductOption::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateProductOptionRequest::fake();
        $this->postJson(route('admin.product-option.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductOption::Table(), 0);
    }
}
