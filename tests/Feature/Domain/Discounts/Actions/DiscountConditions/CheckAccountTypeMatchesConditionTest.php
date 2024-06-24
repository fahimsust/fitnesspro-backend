<?php

namespace Tests\Feature\Domain\Discounts\Actions\DiscountConditions;

use App\Firebase\User;
use Domain\Accounts\Models\Account;
use Domain\Discounts\Actions\DiscountConditions\CheckAccountTypeMatchesCondition;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\ConditionAccountType;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;

class CheckAccountTypeMatchesConditionTest extends TestCase
{
    use HasTestAccount;

    /** @test */
    public function check_account_type()
    {
        $account = Account::factory()->create();
        $this->actingAs(new User($account), 'firebase');
        $condition = DiscountCondition::factory()->create(['condition_type_id'=>DiscountConditionTypes::REQUIRED_ACCOUNT_TYPE]);
        ConditionAccountType::factory()->create();

        $check = new CheckAccountTypeMatchesCondition(
            new DiscountCheckerData(),
            $condition
        );
        $check->account($account);

        $this->assertTrue($check->check());
    }

}
