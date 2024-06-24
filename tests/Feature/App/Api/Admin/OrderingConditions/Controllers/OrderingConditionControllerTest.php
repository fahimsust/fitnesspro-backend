<?php

namespace Tests\Feature\App\Api\Admin\OrderingConditions\Controllers;

use Domain\Products\Enums\OrderingConditionTypes;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingConditionItem;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Illuminate\Support\Facades\Auth;
use Support\Enums\MatchAllAnyString;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderingConditionControllerTest extends ControllerTestCase
{
    private OrderingRule $orderingRule;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderingRule = OrderingRule::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_ordering_condition()
    {
        $this->postJson(route('admin.ordering-condition.store'), ['rule_id' => $this->orderingRule->id, 'type' => OrderingConditionTypes::REQUIRED_ACCOUNT_TYPE])
            ->assertCreated()
            ->assertJsonStructure(['id', 'rule_id', 'type']);

        $this->assertDatabaseCount(OrderingCondition::Table(), 1);
    }

    /** @test */
    public function can_update_ordering_condition()
    {
        $orderingCondition = OrderingCondition::factory()->create();

        $this->putJson(route('admin.ordering-condition.update', [$orderingCondition]), ['any_all' => MatchAllAnyString::ANY])
            ->assertCreated();

        $this->assertEquals(MatchAllAnyString::ANY, $orderingCondition->refresh()->any_all);
    }

    /** @test */
    public function can_delete_ordering_condition()
    {
        $orderingCondition = OrderingCondition::factory()->create(['type' => OrderingConditionTypes::REQUIRED_SPECIALTY]);
        OrderingConditionItem::factory()->create(['condition_id' => $orderingCondition->id]);

        $this->deleteJson(route('admin.ordering-condition.destroy', [$orderingCondition->first()]))
            ->assertOk();

        $this->assertDatabaseCount(OrderingCondition::Table(), 0);
        $this->assertDatabaseCount(OrderingConditionItem::Table(), 0);
    }

    /** @test */
    public function can_get_ordering_conditions_list_with_specialties()
    {
        OrderingCondition::factory(5)
            ->create([
                'rule_id' => $this->orderingRule->id,
                'type' => OrderingConditionTypes::REQUIRED_SPECIALTY
            ])
            ->each(
                fn(OrderingCondition $condition) => OrderingConditionItem::factory(3)
                    ->for($condition, 'condition')
                    ->create()
            );

        $this->getJson(
            route('admin.ordering-rule.conditions.list', $this->orderingRule)
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'rule_id',
                    'type',
                    'specialties'
                ]
            ])->assertJsonCount(5);
    }
    /** @test */
    public function can_get_ordering_conditions_list_with_account_type()
    {
        OrderingCondition::factory(5)
            ->create([
                'rule_id' => $this->orderingRule->id,
                'type' => OrderingConditionTypes::REQUIRED_ACCOUNT_TYPE
            ])
            ->each(
                fn(OrderingCondition $condition) => OrderingConditionItem::factory(3)
                    ->for($condition, 'condition')
                    ->create()
            );

        $this->getJson(
            route('admin.ordering-rule.conditions.list', $this->orderingRule)
        )
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'rule_id',
                    'type',
                    'account_types'
                ]
            ])->assertJsonCount(5);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.ordering-condition.store'), ['rule_id' => $this->orderingRule->id])
            ->assertJsonValidationErrorFor('type')
            ->assertStatus(422);

        $this->assertDatabaseCount(OrderingCondition::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.ordering-condition.store'), ['rule_id' => $this->orderingRule->id, 'type' => OrderingConditionTypes::REQUIRED_ACCOUNT_TYPE])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(OrderingCondition::Table(), 0);
    }
}
