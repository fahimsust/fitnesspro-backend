<?php

namespace Tests\Feature\App\Api\Admin\OrderingRules\Controllers;

use App\Api\Admin\OrderingRules\Requests\OrderingRuleRequest;
use Domain\Products\Actions\OrderingRules\DeleteOrderingRule;
use Domain\Products\Models\DatesAutoOrderRules\DatesAutoOrderRuleAction;
use Domain\Products\Models\OrderingRules\OrderingCondition;
use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleSubRule;
use Domain\Products\Models\Product\ProductPricing;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderingRuleControllerTest extends ControllerTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_create_new_ordering_rule()
    {
        OrderingRuleRequest::fake();

        $this->postJson(route('admin.ordering-rule.store'))
            ->assertCreated()
            ->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseCount(OrderingRule::Table(), 1);
    }

    /** @test */
    public function can_update_ordering_rule()
    {
        $orderingRule = OrderingRule::factory()->create();
        OrderingRuleRequest::fake(['name' => 'test']);

        $this->putJson(route('admin.ordering-rule.update', [$orderingRule]))
            ->assertCreated();

        $this->assertEquals('test', $orderingRule->refresh()->name);
    }

    /** @test */
    public function can_delete_ordering_rule()
    {
        $orderingRule = OrderingRule::factory(5)->create();
        DatesAutoOrderRuleAction::factory()->create(['criteria_orderingruleid' => $orderingRule->first()->id]);
        OrderingCondition::factory()->create(['rule_id' => $orderingRule->first()->id]);

        $this->deleteJson(route('admin.ordering-rule.destroy', [$orderingRule->first()]))
            ->assertOk();

        $this->assertDatabaseCount(OrderingRule::Table(), 4);
        $this->assertDatabaseCount(DatesAutoOrderRuleAction::Table(), 0);
        $this->assertDatabaseCount(OrderingCondition::Table(), 0);
    }

    /** @test */
    public function can_get_exception_for_product_exists()
    {
        $orderingRule = OrderingRule::factory()->create();
        ProductPricing::factory()->create(['ordering_rule_id' => $orderingRule->id]);

        $response = $this->deleteJson(route('admin.ordering-rule.destroy', [$orderingRule]))
            ->assertStatus(500);
        $this->assertStringContainsString('product', strtolower($response['message']));
    }
    /** @test */
    public function can_get_exception_for_child_exists()
    {
        $orderingRule = OrderingRule::factory()->create();
        OrderingRuleSubRule::factory()->create(['parent_rule_id' => $orderingRule->id]);

        $response = $this->deleteJson(route('admin.ordering-rule.destroy', [$orderingRule]))
            ->assertStatus(500);
        $this->assertStringContainsString('child rules', $response['message']);
    }
    /** @test */
    public function can_get_all_ordering_rules()
    {
        OrderingRule::factory(30)->create();

        $this->getJson(route('admin.ordering-rule.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'any_all'
                ]
            ])->assertJsonCount(30);
    }

    /** @test */
    public function can_get_ordering_rules_list()
    {
        OrderingRule::factory(30)->create();

        $response = $this->getJson(route('admin.ordering-rules.list', ["per_page" => 5, "page" => 2]))
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'any_all'
                ]
            ]])
            ->assertJsonCount(5, 'data');
        $this->assertEquals(2, $response['current_page']);
    }
    /** @test */
    public function can_search_ordering_rules()
    {
        OrderingRule::factory()->create(['name' => 'test1']);
        OrderingRule::factory()->create(['name' => 'test2']);
        OrderingRule::factory()->create(['name' => 'not_match']);

        $this->getJson(
            route('admin.ordering-rules.list',["per_page" => 5, "page" => 1, 'keyword' => 'test']),
        )
            ->assertOk()
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'name',
                    'any_all'
                ]
            ]])->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_validate_request_and_return_errors()
    {
        OrderingRuleRequest::fake(['name' => '']);

        $this->postJson(route('admin.ordering-rule.store'))
            ->assertJsonValidationErrorFor('name')
            ->assertStatus(422);

        $this->assertDatabaseCount(OrderingRule::Table(), 0);
    }

    /** @test */
    public function can_handle_errors()
    {
        $this->partialMock(DeleteOrderingRule::class)
            ->shouldReceive('handle')
            ->andThrow(new \Exception("test"));

        $orderingRule = OrderingRule::factory(5)->create();

        $this->deleteJson(route('admin.ordering-rule.destroy', [$orderingRule->first()]))
            ->assertStatus(500)
            ->assertJsonFragment(['message' => "test",]);

        $this->assertDatabaseCount(OrderingRule::Table(), 5);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        OrderingRuleRequest::fake();

        $this->postJson(route('admin.ordering-rule.store'))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(OrderingRule::Table(), 0);
    }
}
