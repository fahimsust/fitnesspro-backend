<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformSetOrderingRuleTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_ordering_rule()
    {
        $oredringRule = OrderingRule::factory()->create();
        $oredringRule2 = OrderingRule::factory()->create();
        $site = Site::factory()->create();
        $products = Product::factory(10)->create();
        foreach($products as $product)
        {
            ProductPricing::factory()->create([
                'product_id'=> $product->id,
                'site_id' => $site->id,
                'ordering_rule_id'=> $oredringRule->id
            ]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_ORDERING_RULE,
                'ordering_rule_id' => $oredringRule2->id,
                'site_id' => $site->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals($oredringRule2->id, ProductPricing::first()->ordering_rule_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $site = Site::factory()->create();
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::SET_ORDERING_RULE,
                'site_id' => $site->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('ordering_rule_id')
        ->assertStatus(422);
    }
}
