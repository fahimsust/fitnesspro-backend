<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformProductTypeUpdateTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_product_type()
    {
        $productTypes = ProductType::factory(2)->create();
        $products = Product::factory(10)->create();
        foreach($products as $product)
        {
            ProductDetail::factory()->create(['product_id'=>$product->id,'type_id'=>$productTypes[0]->id]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_PRODUCT_TYPE,
                'product_type_id' => $productTypes[1]->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals($productTypes[1]->id, ProductDetail::first()->type_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_PRODUCT_TYPE,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('product_type_id')
        ->assertStatus(422);
    }
}
