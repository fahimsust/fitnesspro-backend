<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\UpdateProductDetailsTypeRequest;
use Domain\Products\Actions\Product\UpdateProductDetailsType;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class UpdateProductDetailsTypeControllerTest extends ControllerTestCase
{
    public Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        ProductDetail::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_product_details()
    {
        $productType = ProductType::factory()->create();
        ProductAttribute::factory()->create();

        UpdateProductDetailsTypeRequest::fake(['type_id' => $productType->id]);

        $this->postJson(route('admin.product.update-type', [$this->product]))
            ->assertCreated()
            ->assertJsonStructure(['details'=>['type_id']]);

        $this->assertEquals($productType->id, ProductDetail::first()->type_id);
        $this->assertDatabaseCount(ProductAttribute::Table(), 0);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        UpdateProductDetailsTypeRequest::fake(['type_id' => 0]);
        $this->postJson(route('admin.product.update-type', [$this->product]))
            ->assertJsonValidationErrorFor('type_id')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductDetailsType::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        UpdateProductDetailsTypeRequest::fake();

        $this->postJson(route('admin.product.update-type', [$this->product]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $productType = ProductType::factory()->create();
        UpdateProductDetailsTypeRequest::fake(['type_id' => $productType->id]);

        $this->postJson(route('admin.product.update-type', [$this->product]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals($productType->id, ProductDetail::first()->type_id);
    }
}
