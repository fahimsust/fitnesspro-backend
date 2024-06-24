<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\DefaultInventoryRequest;
use Domain\Products\Actions\Product\UpdateDefaultInventory;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DefaultInventoryControllerTest extends ControllerTestCase
{
    public Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_product_inventory()
    {
        DefaultInventoryRequest::fake(['default_cost' => 100]);

        $this->postJson(route('admin.product.default-inventory.store', [$this->product]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals(100, $this->product->refresh()->default_cost);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        DefaultInventoryRequest::fake(['default_cost' => "test"]);

        $this->postJson(route('admin.product.default-inventory.store', [$this->product]))
            ->assertJsonValidationErrorFor('default_cost')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateDefaultInventory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        DefaultInventoryRequest::fake();

        $this->postJson(route('admin.product.default-inventory.store', [$this->product]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        DefaultInventoryRequest::fake();

        $this->postJson(route('admin.product.default-inventory.store', [$this->product]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
