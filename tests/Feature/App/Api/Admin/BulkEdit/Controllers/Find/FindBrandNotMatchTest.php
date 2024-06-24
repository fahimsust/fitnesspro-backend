<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;

use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindBrandNotMatchTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_search_product_by_product_brand_not_matched()
    {
        $products = Product::factory(10)->create();
        $brand = Brand::factory()->create();
        $brand2 = Brand::factory()->create();

        ProductDetail::factory()->create(['brand_id' => $brand->id, 'product_id' => $products[0]->id]);
        ProductDetail::factory()->create(['brand_id' => $brand->id, 'product_id' => $products[1]->id]);
        foreach ($products as $key => $product) {
            if ($key > 1) {
                ProductDetail::factory()->create(
                    [
                        'brand_id' => $brand2->id,
                        'product_id' => $product->id
                    ]
                );
            }
        }
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::BRAND_IS_NOT->value,
                'brand_id' => $brand->id,
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
                'search_option' => SearchOptions::BRAND_IS_NOT->value,
            ]
        )
            ->assertJsonValidationErrorFor('brand_id')
            ->assertStatus(422);
    }
}
