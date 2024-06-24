<?php

namespace Tests\Feature\Domain\Discounts\Actions\DiscountConditions;

use App\Firebase\User;
use Carbon\Carbon;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Discounts\Actions\DiscountConditions\CheckMembershipExpiresWithinRequiredDays;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\ConditionMembershipLevel;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;

class CheckMembershipExpiresInRequiredDaysTest extends TestCase
{
    use HasTestAccount;

    /** @test */
    public function check_membership_expire()
    {
        $account = Account::factory()->create();
        $this->actingAs(new User($account), 'firebase');
        $condition = DiscountCondition::factory()->create(['required_code' => 10, 'condition_type_id' => DiscountConditionTypes::MEMBERSHIP_EXPIRES_IN_DAYS]);
        ConditionMembershipLevel::factory()->create();
        Subscription::factory()->create(['end_date' => Carbon::now()->addDay(10)->toDateTimeString()]);

        $check = new CheckMembershipExpiresWithinRequiredDays(
            new DiscountCheckerData(),
            $condition
        );
        $check->account($account);

        $this->assertTrue($check->check());
    }
}
