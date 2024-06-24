<?php

namespace Tests\Feature\App\Api\Admin\OrderingRules\Controllers;

use Domain\Products\Actions\OrderingRules\AssignChildRuleToOrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleSubRule;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderingRuleChildControllerTest extends ControllerTestCase
{
    public OrderingRule $parentOrderingRule;
    public OrderingRule $childOrderingRule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->parentOrderingRule = OrderingRule::factory()->create();
        $this->childOrderingRule = OrderingRule::factory()->create();
    }

    /** @test */
    public function can_assign_child_rule_to_ordering_rule()
    {
        $this->postJson(route('admin.ordering-rule.child.store', $this->parentOrderingRule), ["child_rule_id" => $this->childOrderingRule->id])
            ->assertCreated()
            ->assertJsonStructure(['parent_rule_id', 'child_rule_id']);

        $this->assertDatabaseCount(OrderingRuleSubRule::Table(), 1);
    }

    /** @test */
    public function can_remove_child_rule_from_ordering_rule()
    {
        OrderingRuleSubRule::factory()->create(['parent_rule_id' => $this->parentOrderingRule->id, 'child_rule_id' => $this->childOrderingRule->id]);

        $this->deleteJson(
            route('admin.ordering-rule.child.destroy', [$this->parentOrderingRule, $this->childOrderingRule]),
        )->assertOk();

        $this->assertDatabaseCount(OrderingRuleSubRule::Table(), 0);
    }

    /** @test */
    public function can_ordering_rule_for_assign()
    {
        $orderingRule = OrderingRule::factory(20)->create(['name' => 'test1111']);
        OrderingRuleSubRule::factory()->create(['parent_rule_id' => $orderingRule[0]->id, 'child_rule_id' => $orderingRule[1]->id]);
        $this->getJson(route('admin.ordering-rule.children', [$orderingRule[0], 'keyword' => 'test1111']),)
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name']])
            ->assertJsonCount(18);
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $this->postJson(route('admin.ordering-rule.child.store', $this->parentOrderingRule), ["child_rule_id" => 0])
            ->assertJsonValidationErrorFor('child_rule_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(OrderingRuleSubRule::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(AssignChildRuleToOrderingRule::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $this->postJson(route('admin.ordering-rule.child.store', $this->parentOrderingRule), ["child_rule_id" => $this->childOrderingRule->id])
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(OrderingRuleSubRule::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.ordering-rule.child.store', $this->parentOrderingRule), ["child_rule_id" => $this->childOrderingRule->id])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(OrderingRuleSubRule::Table(), 0);
    }
}
