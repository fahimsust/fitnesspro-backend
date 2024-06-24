<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use App\Api\Admin\Products\Requests\DistributorsInventoryRequest;
use Domain\Distributors\Models\Distributor;
use Domain\Products\Actions\Product\UpdateOrCreateDistributorInventory;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DistributorsInventoryControllerTest extends ControllerTestCase
{
    public Product $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function get_product_distributor_inventory()
    {
        $distributors = Distributor::factory(5)->create();
        ProductDistributor::factory()->create(['distributor_id'=>$distributors[0]->id,'product_id'=>$this->product->id]);

        $this->getJson(route('admin.product.distributor-inventory.index', $this->product))
        ->assertOk()
        ->assertJsonStructure(['*'=>['id', 'name','cost','outofstockstatus_id','stock_qty']])
        ->assertJsonCount(5);
    }

    /** @test */
    public function can_update_product_inventory()
    {
        DistributorsInventoryRequest::fake(['cost' => 100]);

        $this->postJson(route('admin.product.distributor-inventory.store', [$this->product]))
            ->assertCreated();

        $this->assertEquals(100, $this->product->productDistributors()->first()->cost);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        DistributorsInventoryRequest::fake(['cost' => "test"]);

        $this->postJson(route('admin.product.distributor-inventory.store', [$this->product]))
            ->assertJsonValidationErrorFor('cost')
            ->assertStatus(422);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(UpdateOrCreateDistributorInventory::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        DistributorsInventoryRequest::fake();

        $this->postJson(route('admin.product.distributor-inventory.store', [$this->product]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        DistributorsInventoryRequest::fake();

        $this->postJson(route('admin.product.distributor-inventory.store', [$this->product]))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
