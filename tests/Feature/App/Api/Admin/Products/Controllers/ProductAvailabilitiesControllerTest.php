<?php

namespace Tests\Feature\App\Api\Admin\Products\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionOutOfStockStatus;
use Domain\Discounts\Models\Rule\Condition\ConditionProductAvailability;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\ProductAvailability;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ProductAvailabilitiesControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_product_availabilities()
    {
        ProductAvailability::factory(5)->create();

        $this->getJson(route('admin.product-availabilities'))
            ->assertOk()
            ->assertJsonCount(5)
            ->assertJsonStructure(["*" => ['id', 'name']]);
    }
    /** @test */
    public function can_search_out_of_stock_status_for_discount_condition()
    {
        $discountCondition = DiscountCondition::factory()->create();
        $productAvailability = ProductAvailability::factory(10)->create();
        ConditionOutOfStockStatus::factory()->create(['outofstockstatus_id' => $productAvailability[0]->id, 'condition_id' => $discountCondition->id]);
        ConditionOutOfStockStatus::factory()->create(['outofstockstatus_id' => $productAvailability[1]->id, 'condition_id' => $discountCondition->id]);
        ConditionOutOfStockStatus::factory()->create(['outofstockstatus_id' => $productAvailability[2]->id, 'condition_id' => $discountCondition->id]);
        $this->getJson(
            route('admin.product-availabilities', ['condition_id' => $discountCondition->id]),
        )
            ->assertOk()
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'name',
                        'display'
                    ]
                ]
            )->assertJsonCount(7);
    }

     /** @test */
     public function can_search_availability_for_discount_condition()
     {
         $discountCondition = DiscountCondition::factory()->create();
         $productAvailability = ProductAvailability::factory(10)->create();
         ConditionProductAvailability::factory()->create(['availability_id' => $productAvailability[0]->id, 'condition_id' => $discountCondition->id]);
         ConditionProductAvailability::factory()->create(['availability_id' => $productAvailability[1]->id, 'condition_id' => $discountCondition->id]);
         ConditionProductAvailability::factory()->create(['availability_id' => $productAvailability[2]->id, 'condition_id' => $discountCondition->id]);
         $this->getJson(
             route('admin.product-availabilities', ['availability_condition_id' => $discountCondition->id]),
         )
             ->assertOk()
             ->assertJsonStructure(
                 [
                     '*' => [
                         'id',
                         'name',
                         'display'
                     ]
                 ]
             )->assertJsonCount(7);
     }
}
