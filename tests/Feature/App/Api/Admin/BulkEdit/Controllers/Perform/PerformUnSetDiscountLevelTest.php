<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformUnSetDiscountLevelTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_unassign_discount_level()
    {
        $discountLevel = DiscountLevel::factory()->create();
        $products = Product::factory(10)->create();
        foreach($products as $product)
        {
            DiscountLevelProduct::factory()->create(['product_id'=>$product->id,'discount_level_id'=>$discountLevel->id]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::UNASSIGN_FROM_DISCOUNT_LEVEL,
                'discount_level_id' => $discountLevel->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertOk();
        $this->assertDatabaseCount(DiscountLevelProduct::Table(), 0);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::UNASSIGN_FROM_DISCOUNT_LEVEL,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('discount_level_id')
        ->assertStatus(422);
    }
}
