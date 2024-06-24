<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\BulkEdit\BulkEditActivity;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformPriceTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_product_price()
    {
        $site = Site::factory()->create();
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_PRICING,
                'price_reg' => 100,
                'onsale' => true,
                'price_sale' => 40,
                'site_id' => $site->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals(100, ProductPricing::first()->price_reg);
        $this->assertEquals(40, ProductPricing::first()->price_sale);
        $this->assertDatabaseCount(BulkEditActivity::Table(), 1);
        $this->assertDatabaseCount(ProductPricing::Table(), 10);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $site = Site::factory()->create();
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_PRICING,
                'site_id' => $site->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('price_reg')
        ->assertStatus(422);
    }
}
