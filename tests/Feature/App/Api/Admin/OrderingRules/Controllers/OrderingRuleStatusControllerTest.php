<?php

namespace Tests\Feature\App\Api\Admin\OrderingRules\Controllers;

use Domain\Products\Models\OrderingRules\OrderingRule;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class OrderingRuleStatusControllerTest extends ControllerTestCase
{
    public OrderingRule $orderingRule;
    protected function setUp(): void
    {
        parent::setUp();
        $this->orderingRule = OrderingRule::factory()->create();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_active_ordering_rule()
    {
        $this->orderingRule->update(['status'=>false]);
        $this->postJson(route('admin.ordering-rule.status', [$this->orderingRule]),['status'=>true])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertTrue($this->orderingRule->refresh()->status);
    }
    /** @test */
    public function can_deactivate_ordering_rule()
    {
        $this->postJson(route('admin.ordering-rule.status', [$this->orderingRule]),['status'=>false])
            ->assertCreated()
            ->assertJsonStructure(['id']);
        $this->assertFalse($this->orderingRule->refresh()->status);
    }

     /** @test */
     public function can_validate_request_and_return_errors()
     {
        $this->postJson(route('admin.ordering-rule.status', [$this->orderingRule]),['status'=>''])
             ->assertJsonValidationErrorFor('status')
             ->assertStatus(422);
     }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $this->postJson(route('admin.ordering-rule.status', [$this->orderingRule]),['status'=>false])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);
    }
}
