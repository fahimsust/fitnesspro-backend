<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductTypeNotMatchTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_search_product_by_product_type_not_matched()
    {
        $products = Product::factory(10)->create();
        $productType = ProductType::factory()->create();
        $productType2 = ProductType::factory()->create();

        ProductDetail::factory()->create(['type_id'=>$productType->id,'product_id'=>$products[0]->id]);
        ProductDetail::factory()->create(['type_id'=>$productType->id,'product_id'=>$products[1]->id]);
        foreach($products as $key=>$product)
        {
            if($key > 1)
            {
                ProductDetail::factory()->create(['type_id'=>$productType2->id,'product_id'=>$product->id]);
            }
        }
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::PRODUCT_TYPE_IS_NOT->value,
                'product_type_id' => $productType->id,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(8);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::PRODUCT_TYPE_IS_NOT->value,
            ]
        )
        ->assertJsonValidationErrorFor('product_type_id')
        ->assertStatus(422);
    }
}
