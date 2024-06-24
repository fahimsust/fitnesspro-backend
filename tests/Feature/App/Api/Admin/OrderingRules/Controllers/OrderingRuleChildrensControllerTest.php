<?php

namespace Tests\Feature\App\Api\Admin\OrderingRules\Controllers;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Domain\Products\Models\OrderingRules\OrderingRuleSubRule;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderingRuleChildrensControllerTest extends ControllerTestCase
{
    public OrderingRule $orderingRule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAndAuthAdminUser();
        $this->orderingRule = OrderingRule::factory()->create();
    }

    /** @test */
    public function can_get_child_rules()
    {
        OrderingRuleSubRule::factory(5)->create(['parent_rule_id'=>$this->orderingRule->id]);
        $this->getJson(route('admin.ordering-rule-childs.list', $this->orderingRule))
            ->assertOk()
            ->assertJsonStructure(["*" => ['id', 'name']])
            ->assertJsonCount(5);
    }


    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->getJson(route('admin.ordering-rule-childs.list', $this->orderingRule))
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
