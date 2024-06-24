<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformWeightUpdateTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_change_weight()
    {
        $products = Product::factory(10)->create(['weight' => 50]);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_WEIGHT,
                'weight' => 100,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals(100, Product::first()->weight);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_WEIGHT,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertJsonValidationErrorFor('weight')
            ->assertStatus(422);
    }
}
