<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\UpdateProductDetailsRequest;
use Domain\Products\Actions\Product\UpdateProductDetails;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductDetailsControllerTest extends ControllerTestCase
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
        UpdateProductDetailsRequest::fake(['downloadable_file' => 'test']);

        $this->postJson(route('admin.product.details', [$this->product]))
            ->assertCreated()
            ->assertJsonStructure(['details'=>['downloadable_file', 'type_id', 'brand_id', 'default_category_id']]);

        $this->assertEquals('test', ProductDetail::first()->downloadable_file);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        UpdateProductDetailsRequest::fake(['brand_id' => 0]);
        $this->postJson(route('admin.product.details', [$this->product]))
            ->assertJsonValidationErrorFor('brand_id')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductDetails::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        UpdateProductDetailsRequest::fake(['downloadable_file' => 'test']);

        $this->postJson(route('admin.product.details', [$this->product]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals('test', ProductDetail::first()->downloadable_file);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        UpdateProductDetailsRequest::fake(['downloadable_file' => 'test']);

        $this->postJson(route('admin.product.details', [$this->product]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals('test', ProductDetail::first()->downloadable_file);
    }
}
