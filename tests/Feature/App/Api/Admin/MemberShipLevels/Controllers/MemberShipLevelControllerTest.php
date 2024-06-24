<?php

namespace Tests\Feature\App\Api\Admin\MemberShipLevels\Controllers;

use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Tests\Feature\App\Api\Admin\Controllers\ControllerTestCase;
use function route;

class MemberShipLevelControllerTest extends ControllerTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->createAndAuthAdminUser();
    }

    /** @test */
    public function can_get_membership_level()
    {
        MembershipLevel::factory(5)->create();

        $this->getJson(route('admin.membership-level.index'))
            ->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                        ]
                    ]
                ]
            )->assertJsonCount(5,'data');
    }

    /** @test */
    public function can_search_membership_level_for_discount_condition()
    {
        $discountCondition = DiscountCondition::factory()->create();
        $membershipLevels = MembershipLevel::factory(10)->create();
        ConditionMembershipLevel::factory()->create(['membershiplevel_id' => $membershipLevels[0]->id, 'condition_id' => $discountCondition->id]);
        ConditionMembershipLevel::factory()->create(['membershiplevel_id' => $membershipLevels[1]->id, 'condition_id' => $discountCondition->id]);
        ConditionMembershipLevel::factory()->create(['membershiplevel_id' => $membershipLevels[2]->id, 'condition_id' => $discountCondition->id]);
        $this->getJson(
            route('admin.membership-level.index', ['condition_id' => $discountCondition->id]),
        )
            ->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                        ]
                    ]
                ]
            )->assertJsonCount(7,'data');
    }
}
