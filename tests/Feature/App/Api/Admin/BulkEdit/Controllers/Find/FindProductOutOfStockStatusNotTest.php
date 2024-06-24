<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductOutOfStockStatusNotTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_availability()
    {
        $availability = ProductAvailability::factory()->create();
        $availability2 = ProductAvailability::factory()->create();
        Product::factory(10)->create(['default_outofstockstatus_id'=>$availability->id]);
        Product::factory(5)->create(['default_outofstockstatus_id'=>$availability2->id]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DEFAULT_OUT_OF_STOCK_STATUS_IS_NOT->value,
                'out_of_stock_status' => $availability->id,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(5);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::DEFAULT_OUT_OF_STOCK_STATUS_IS_NOT->value,
            ]
        )
        ->assertJsonValidationErrorFor('out_of_stock_status')
        ->assertStatus(422);
    }
}
