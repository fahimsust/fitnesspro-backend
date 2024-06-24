<?php

namespace Tests\Feature\App\Api\Admin\BulkEdit\Controllers\Perform;

use Domain\Discounts\Models\Level\DiscountLevel;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class PerformSetDiscountLevelTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_change_discount_level()
    {
        $discountLevel = DiscountLevel::factory(2)->create();
        $products = Product::factory(10)->create();
        foreach($products as $product)
        {
            DiscountLevelProduct::factory()->create(['product_id'=>$product->id,'discount_level_id'=>$discountLevel[0]->id]);
        }
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_TO_DISCOUNT_LEVEL,
                'discount_level_id' => $discountLevel[1]->id,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
            ->assertOk();
        $this->assertEquals($discountLevel[1]->id, DiscountLevelProduct::first()->discount_level_id);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $products = Product::factory(10)->create();
        $this->postJson(
            route('admin.bulk-edit-perform.store'),
            [
                'action_name' => ActionList::ASSIGN_TO_DISCOUNT_LEVEL,
                'ids' => $products->pluck('id')->toArray()
            ]
        )
        ->assertJsonValidationErrorFor('discount_level_id')
        ->assertStatus(422);
    }
}
