<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;


use App\Api\Admin\Products\Requests\CreateProductRequest;
use App\Api\Admin\Products\Requests\ProductBasicsRequest;
use Domain\Products\Actions\Product\CreateProduct;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Products\Models\Product\Settings\ProductSettings;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_product()
    {
        CreateProductRequest::fake();

        $this->postJson(route('admin.product.store'))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(Product::Table(), 1);
        $this->assertDatabaseCount(ProductSettings::Table(), 1);
        $this->assertDatabaseCount(ProductDetail::Table(), 1);
        $this->assertDatabaseCount(ProductPricing::Table(), 1);
    }

    /** @test */
    public function can_get_product()
    {
        $product = Product::factory()->create();
        $this->getJson(route('admin.product.show', [$product]))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'id',
                    'title',
                    'details',
                    'options_count'
                ]
            );
    }

    /** @test */
    public function can_update_product()
    {
        $product = Product::factory()->create();
        ProductBasicsRequest::fake(['title' => 'test']);

        $this->putJson(route('admin.product.update', [$product]))
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertEquals('test',$product->refresh()->title);
    }

    /** @test */
    public function can_delete_product()
    {
        $product = Product::factory(5)->create();

        $this->deleteJson(route('admin.product.destroy', [$product->first()]))
            ->assertOk();

        $this->assertEquals(4,Product::count());
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        CreateProductRequest::fake(['title' => '']);

        $this->postJson(route('admin.product.store'))
            ->assertJsonValidationErrorFor('title')
            ->assertStatus(422);

        $this->assertDatabaseCount(Product::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateProduct::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        CreateProductRequest::fake();

        $this->postJson(route('admin.product.store'))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(Product::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        CreateProductRequest::fake();

        $this->postJson(route('admin.product.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(Product::Table(), 0);
    }
}
