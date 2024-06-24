<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Find;

use Domain\Products\Enums\BulkEdit\SearchOptions;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;

use function route;

class FindProductByOrderingRuleTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_search_product_by_ordering_rule()
    {
        $products = Product::factory(10)->create();
        $orderingRule = OrderingRule::factory()->create();
        ProductPricing::factory()->create(['ordering_rule_id'=>$orderingRule->id,'product_id'=>$products[0]->id]);
        ProductPricing::factory()->create(['ordering_rule_id'=>$orderingRule->id,'product_id'=>$products[1]->id]);
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::ORDERING_RULE_IS->value,
                'ordering_rule_id' => $orderingRule->id,
            ]
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                ]
            ])
            ->assertJsonCount(2);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(
            route('admin.bulk-edit-find.store'),
            [
                'search_option' => SearchOptions::ORDERING_RULE_IS->value,
            ]
        )
        ->assertJsonValidationErrorFor('ordering_rule_id')
        ->assertStatus(422);
    }
}
