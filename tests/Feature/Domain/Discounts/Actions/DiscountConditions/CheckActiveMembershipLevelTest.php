<?php

namespace Tests\Feature\Domain\Discounts\Actions\DiscountConditions;

use App\Firebase\User;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Discounts\Actions\DiscountConditions\CheckActiveMembershipLevel;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;

class CheckActiveMembershipLevelTest extends TestCase
{
    use HasTestAccount;

    /** @test */
    public function check_membership_level()
    {
        $account = Account::factory()->create();
        $this->actingAs(new User($account), 'firebase');
        $condition = DiscountCondition::factory()->create(['condition_type_id' => DiscountConditionTypes::ACTIVE_MEMBERSHIP_LEVEL]);
        ConditionMembershipLevel::factory()->create();
        Subscription::factory()->create();

        $check = new CheckActiveMembershipLevel(
            new DiscountCheckerData(),
            $condition
        );
        $check->account($account);

        $this->assertTrue($check->check());
    }
}
