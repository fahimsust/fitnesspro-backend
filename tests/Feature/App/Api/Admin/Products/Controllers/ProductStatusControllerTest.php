<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Products\Actions\Product\UpdateProductStatus;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductStatusControllerTest extends ControllerTestCase
{
    public Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_change_product_status()
    {
        $this->postJson(route('admin.product.status', [$this->product]), ['status' => 1])
            ->assertCreated()
            ->assertJsonStructure(['status']);

        $this->assertEquals(1,$this->product->refresh()->status);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.product.status', [$this->product]), ['status' => ""])
            ->assertJsonValidationErrorFor('status')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductStatus::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.product.status', [$this->product]), ['status' => 1])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.product.status', [$this->product]), ['status' => 1])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

    }
}
