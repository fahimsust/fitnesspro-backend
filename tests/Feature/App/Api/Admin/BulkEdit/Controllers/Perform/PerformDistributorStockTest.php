<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformDistributorStockTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_brand()
    {
        $distributors = Distributor::factory(2)->create();
        $mainProducts = Product::factory(2)->create(['combined_stock_qty'=>50]);
        $productsFromFirstParent = Product::factory(5)->create(['parent_product'=>$mainProducts[0]->id,'combined_stock_qty'=>10]);
        $productsFromSecondParent = Product::factory(5)->create(['parent_product'=>$mainProducts[1]->id,'combined_stock_qty'=>10]);
        $products = $productsFromFirstParent->concat($productsFromSecondParent);
        foreach($products as $product)
        {
            ProductDistributor::factory()->create(['product_id'=>$product->id,'stock_qty'=>5,'distributor_id'=>$distributors[0]->id]);
            ProductDistributor::factory()->create(['product_id'=>$product->id,'stock_qty'=>5,'distributor_id'=>$distributors[1]->id]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::MODIFY_DISTRIBUTOR_STOCK_QTY,
                'distributor_id' => $distributors[1]->id,
                'stock_qty'=>1,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $productQtySum = ProductDistributor::whereDistributorId($distributors[1]->id)->sum('stock_qty');
        $productCombinedQtySum = Product::whereNotNull('parent_product')->sum('combined_stock_qty');
        $productParentCombinedQtySum = Product::whereNull('parent_product')->sum('combined_stock_qty');
        $productQtySumPrevious = ProductDistributor::whereDistributorId($distributors[0]->id)->sum('stock_qty');
        $this->assertEquals(10,$productQtySum);
        $this->assertEquals(60,$productCombinedQtySum);
        $this->assertEquals(60,$productParentCombinedQtySum);
        $this->assertEquals(50,$productQtySumPrevious);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::MODIFY_DISTRIBUTOR_STOCK_QTY,
                'stock_qty'=>1,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('distributor_id')
        ->assertStatus(422);
    }
}
