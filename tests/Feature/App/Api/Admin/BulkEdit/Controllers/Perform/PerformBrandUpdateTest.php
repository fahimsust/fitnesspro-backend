<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformBrandUpdateTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_brand()
    {
        $brands = Brand::factory(2)->create();
        $products = Product::factory(10)->create();
        foreach($products as $product)
        {
            ProductDetail::factory()->create(['product_id'=>$product->id,'brand_id'=>$brands[0]->id]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_BRAND,
                'brand_id' => $brands[1]->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals($brands[1]->id, ProductDetail::first()->brand_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_BRAND,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('brand_id')
        ->assertStatus(422);
    }
}
