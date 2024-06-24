<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAvailability;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformAvailabilityChangeTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_availibility()
    {
        $availability = ProductAvailability::factory()->create();
        $chnageavailability = ProductAvailability::factory()->create();
        $products = Product::factory(10)->create(['default_outofstockstatus_id'=>$availability->id]);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_OUT_OF_STOCK_STATUS,
                'out_of_stock_status' => $chnageavailability->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals($chnageavailability->id, Product::first()->default_outofstockstatus_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_OUT_OF_STOCK_STATUS,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('out_of_stock_status')
        ->assertStatus(422);
    }
}
