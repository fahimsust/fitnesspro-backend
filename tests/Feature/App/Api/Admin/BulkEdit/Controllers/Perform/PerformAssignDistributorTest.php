<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Distributors\Models\Distributor;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformAssignDistributorTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_availibility()
    {
        $distributor = Distributor::factory()->create();
        $changeDistributor = Distributor::factory()->create();
        $products = Product::factory(10)->create(['default_distributor_id'=>$distributor->id]);
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_DISTRIBUTOR,
                'distributor_id' => $changeDistributor->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals($changeDistributor->id, Product::first()->default_distributor_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_DISTRIBUTOR,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('distributor_id')
        ->assertStatus(422);
    }
}
