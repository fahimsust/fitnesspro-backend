<?php

namespace Tests\Feature\App\Api\Admin\Discounts\Controllers;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Illuminate\Support\Facades\Auth;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class ConditionMemberShipControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }
    /** @test */
    public function can_create_new_discount_condition_site()
    {
        $membershipLevel = MembershipLevel::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-membership.store'),
        [
            'membershiplevel_id'=>$membershipLevel->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertCreated()
            ->assertJsonStructure(['id']);

        $this->assertDatabaseCount(ConditionMembershipLevel::Table(), 1);
    }

    /** @test */
    public function can_delete_discount_condition_site()
    {
        $discountConditions = DiscountCondition::factory(5)->create();
        $conditionMemberShipLevel = [];
        foreach($discountConditions as $discountCondition)
            $conditionMemberShipLevel[] = ConditionMembershipLevel::factory()->create(['condition_id'=>$discountCondition->id]);

        $this->deleteJson(route('admin.condition-membership.destroy', [$conditionMemberShipLevel[0]]))
            ->assertOk();

        $this->assertDatabaseCount(ConditionMembershipLevel::Table(), 4);
    }
    /** @test */
    public function can_validate_request_and_return_errors()
    {
        $membershipLevel = MembershipLevel::factory()->create();
        $this->postJson(route('admin.condition-membership.store'),
        [
            'membershiplevel_id'=>$membershipLevel->id,
        ])
            ->assertJsonValidationErrorFor('condition_id')
            ->assertStatus(422);

        $this->assertDatabaseCount(ConditionMembershipLevel::Table(), 0);
    }

    /** @test */
    public function show_auth_error()
    {
        Auth::guard('admin')->logout();

        $membershipLevel = MembershipLevel::factory()->create();
        $discountCondition = DiscountCondition::factory()->create();

        $this->postJson(route('admin.condition-membership.store'),
        [
            'membershiplevel_id'=>$membershipLevel->id,
            'condition_id'=>$discountCondition->id
        ])
            ->assertStatus(401)
            ->assertJsonFragment(["message" => "Unauthenticated."]);

        $this->assertDatabaseCount(ConditionMembershipLevel::Table(), 0);
    }
}
