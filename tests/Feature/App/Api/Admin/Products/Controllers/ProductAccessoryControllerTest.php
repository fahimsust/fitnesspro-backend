<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;


use App\Api\Admin\Products\Requests\ProductAccessoryRequest;
use Domain\Products\Actions\Product\CreateProductAccessory;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductAccessoryControllerTest extends ControllerTestCase
{
    public Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_product_accessory()
    {
        $this->getJson(route('admin.product.accessory.index', [$this->product]))
            ->assertOk()
            ->assertJsonStructure(["*" => ['accessory_id', 'product_id','accessory']]);
    }

    /** @test */
    public function can_create_new_product_accessory()
    {
        ProductAccessoryRequest::fake();

        $this->postJson(route('admin.product.accessory.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(["*" => ['accessory_id', 'product_id']]);

        $this->assertDatabaseCount(ProductAccessory::Table(), 1);
    }
    /** @test */
    public function can_update_product_accessory()
    {
        $productAccessory = ProductAccessory::factory()->create(['product_id'=>$this->product->id,'required'=>false]);
        ProductAccessoryRequest::fake(['product_id'=>$this->product->id,'accessory_id'=>$productAccessory->accessory_id,'required'=>true]);

        $this->postJson(route('admin.product.accessory.store', $this->product))
            ->assertCreated()
            ->assertJsonStructure(["*" => ['accessory_id', 'product_id']]);

        $this->assertEquals(true,ProductAccessory::first()->required);
        $this->assertDatabaseCount(ProductAccessory::Table(), 1);
    }

    /** @test */
    public function can_delete_product_accessory()
    {
        $productAccessory = ProductAccessory::factory(5)->create();

        $this->deleteJson(route('admin.product.accessory.destroy', [
            $productAccessory->first()->product,
            $productAccessory->first()->accessory
        ]))
            ->assertOk();

        $this->assertDatabaseCount(ProductAccessory::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        ProductAccessoryRequest::fake(['required' => 123]);

        $this->postJson(route('admin.product.accessory.store', $this->product))
            ->assertJsonValidationErrorFor('required')
            ->assertStatus(422);

        $this->assertDatabaseCount(ProductAccessory::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(CreateProductAccessory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        ProductAccessoryRequest::fake();

        $this->postJson(route('admin.product.accessory.store', $this->product))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(ProductAccessory::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        ProductAccessoryRequest::fake();

        $this->postJson(route('admin.product.accessory.store', $this->product))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ProductAccessory::Table(), 0);
    }
}
