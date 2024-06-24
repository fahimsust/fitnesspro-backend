<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductDetailsRequest;
use Domain\Products\Actions\Product\UpdateProductContent;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductContentControllerTest extends ControllerTestCase
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
        ProductDetailsRequest::fake(['summary'=>'test']);

        $this->postJson(route('admin.product.content', [$this->product]))
            ->assertCreated()
            ->assertJsonStructure(['details'=>['summary', 'description']]);

        $this->assertEquals('test', ProductDetail::first()->summary);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductDetailsRequest::fake(['summary' => '']);
        $this->postJson(route('admin.product.content', [$this->product]))
            ->assertJsonValidationErrorFor('summary')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductContent::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        ProductDetailsRequest::fake(['summary' => 'test']);

        $this->postJson(route('admin.product.content', [$this->product]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertNotEquals('test', ProductDetail::first()->summary);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductDetailsRequest::fake(['summary' => 'test']);

        $this->postJson(route('admin.product.content', [$this->product]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertNotEquals('test', ProductDetail::first()->summary);
    }
}
