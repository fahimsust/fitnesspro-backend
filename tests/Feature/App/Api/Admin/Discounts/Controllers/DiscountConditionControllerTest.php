<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Discounts\Enums\DiscountConditionRequiredQtyTypes;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Domain\Discounts\Models\Rule\DiscountRule;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class DiscountConditionControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_option()
    {
        $this->getJson(route('admin.discount-condition-options.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                ]
            ])
            ->assertJsonCount(count(DiscountConditionTypes::cases()));
    }

    /** @test */
    public function can_create_new_discount_condition()
    {
        $discountRule = DiscountRule::factory()->create();

        $this->postJson(route('admin.discount-rule-condition.store'),
            [
                'rule_id' => $discountRule->id,
                'condition_type_id' => DiscountConditionTypes::MINIMUM_CART_AMOUNT->value
            ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(DiscountCondition::Table(), 1);
    }

    /** @test */
    public function can_update_discount_condition()
    {
        $discountCondition = DiscountCondition::factory()->create();

        $request = [
            'required_cart_value' => 10,
            'required_code' => 'code',
            'required_qty_type' => DiscountConditionRequiredQtyTypes::Individual->value,
            'required_qty_combined' => 10,
            'match_anyall' => 1,
            'rank' => 1,
            'equals_notequals' => true,
            'use_with_rules_products' => true
        ];

        $this->putJson(
            route(
                'admin.discount-rule-condition.update',
                [$discountCondition]
            ),
            $request
        )
            ->assertCreated();

        $this->assertDatabaseHas(DiscountCondition::Table(), $request);
    }

    /** @test */
    public function can_delete_discount_condition()
    {
        $discountCondition = DiscountCondition::factory(5)->create();

        $this->deleteJson(route('admin.discount-rule-condition.destroy', [$discountCondition->first()]))
            ->assertOk();

        $this->assertDatabaseCount(DiscountCondition::Table(), 4);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.discount-rule-condition.store'),
            [
                'condition_type_id' => DiscountConditionTypes::MINIMUM_CART_AMOUNT->value
            ])
            ->assertJsonValidationErrorFor('rule_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(DiscountCondition::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $discountRule = DiscountRule::factory()->create();

        $this->postJson(route('admin.discount-rule-condition.store'),
            [
                'rule_id' => $discountRule->id,
                'advantage_type_id' => DiscountConditionTypes::MINIMUM_CART_AMOUNT->value
            ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(DiscountCondition::Table(), 0);
    }
}
