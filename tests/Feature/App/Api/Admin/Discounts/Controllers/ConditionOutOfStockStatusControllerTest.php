<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Models\Rule\Condition\ConditionOutOfStockStatus;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionOutOfStockStatusControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_discount_condition_availability()
    {
        $productAvailability = ProductAvailability::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(
            route('admin.condition-out-of-stock-status.store'),
            [
                'outofstockstatus_id' => $productAvailability->id,
                'condition_id' => $discountCondition->id
            ]
        )
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionOutOfStockStatus::Table(), 1);
    }

    /** @test */
    public function can_update_discount_condition_availability()
    {
        $conditionOutOfStockStatus = ConditionOutOfStockStatus::factory()->create();
        $request = [
            'required_qty' => 10,
        ];

        $this->putJson(route('admin.condition-out-of-stock-status.update', [$conditionOutOfStockStatus]), $request)
            ->assertCreated();

        $this->assertDatabaseHas(ConditionOutOfStockStatus::Table(), $request);
    }

    /** @test */
    public function can_delete_discount_condition_product()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionOutOfStockStatus = [];
        foreach ($discountConditions as $discountCondition)
            $conditionOutOfStockStatus[] = ConditionOutOfStockStatus::factory()->create(['condition_id' => $discountCondition->id]);

        $this->deleteJson(route('admin.condition-out-of-stock-status.destroy', [$conditionOutOfStockStatus[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionOutOfStockStatus::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $productAvailability = ProductAvailability::factory()->create();
        $this->postJson(
            route('admin.condition-out-of-stock-status.store'),
            [
                'outofstockstatus_id' => $productAvailability->id,
            ]
        )
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionOutOfStockStatus::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $productAvailability = ProductAvailability::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(
            route('admin.condition-out-of-stock-status.store'),
            [
                'outofstockstatus_id' => $productAvailability->id,
                'condition_id' => $discountCondition->id
            ]
        )
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionOutOfStockStatus::Table(), 0);
    }
}
