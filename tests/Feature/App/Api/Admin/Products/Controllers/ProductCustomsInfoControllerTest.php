<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductCustomsInfoRequest;
use Domain\Products\Actions\Product\UpdateProductCustomsInfo;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductCustomsInfoControllerTest extends ControllerTestCase
{
    public Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_product_custom_info()
    {
        ProductCustomsInfoRequest::fake(['customs_description' => 'test']);

        $this->postJson(route('admin.product.customs-info.store', [$this->product]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test', $this->product->refresh()->customs_description);
    }

    /** @test */
    public function can_get_product_custom_info()
    {
        $this->getJson(route('admin.product.customs-info.index', [$this->product]))
            ->assertOk()
            ->assertJsonStructure([
                'customs_description',
                'tariff_number',
                'country_origin'
            ]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductCustomsInfoRequest::fake(['customs_description' => 100]);

        $this->postJson(route('admin.product.customs-info.store', [$this->product]))
            ->assertJsonValidationErrorFor('customs_description')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductCustomsInfo::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        ProductCustomsInfoRequest::fake();

        $this->postJson(route('admin.product.customs-info.store', [$this->product]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductCustomsInfoRequest::fake();

        $this->postJson(route('admin.product.customs-info.store', [$this->product]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
