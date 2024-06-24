<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\ProductMetaDataRequest;
use Domain\Products\Actions\Product\UpdateProductMetaData;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductMetaDataControllerTest extends ControllerTestCase
{
    public Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_update_product_meta_data()
    {
        ProductMetaDataRequest::fake(['meta_title' => 'test']);

        $this->postJson(route('admin.product.meta-data.store', [$this->product]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test', $this->product->refresh()->meta_title);
    }

    /** @test */
    public function can_get_product_meta_data()
    {
        $this->getJson(route('admin.product.meta-data.index', [$this->product]))
            ->assertOk()
            ->assertJsonStructure([
                'meta_title',
                'meta_desc',
                'meta_keywords'
            ]);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductMetaDataRequest::fake(['meta_title' => 100]);

        $this->postJson(route('admin.product.meta-data.store', [$this->product]))
            ->assertJsonValidationErrorFor('meta_title')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateProductMetaData::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        ProductMetaDataRequest::fake();

        $this->postJson(route('admin.product.meta-data.store', [$this->product]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductMetaDataRequest::fake();

        $this->postJson(route('admin.product.meta-data.store', [$this->product]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
