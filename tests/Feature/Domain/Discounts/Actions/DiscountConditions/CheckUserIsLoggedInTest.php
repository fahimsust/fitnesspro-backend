<?php

namespace Tests\Feature\Domain\Discounts\Actions\DiscountConditions;

use App\Firebase\User;
use Domain\Accounts\Models\Account;
use Domain\Discounts\Actions\DiscountConditions\CheckUserIsLoggedIn;
use Domain\Discounts\Dtos\DiscountCheckerData;
use Domain\Discounts\Enums\DiscountConditionTypes;
use Domain\Discounts\Models\Rule\Condition\DiscountCondition;
use Tests\Feature\Traits\HasTestAccount;
use Tests\TestCase;

class CheckUserIsLoggedInTest extends TestCase
{
    use HasTestAccount;

    /** @test */
    public function check_user_login()
    {
        $account = Account::factory()->create();
        $this->actingAs(new User($account), 'firebase');
        $condition = DiscountCondition::factory()->create(['condition_type_id' => DiscountConditionTypes::REQUIRED_ACCOUNT]);

        $checkAccountTypeMatchesCondition = (new CheckUserIsLoggedIn(
            new DiscountCheckerData(),
            $condition
        ))
            ->account($account);

        $this->assertTrue($checkAccountTypeMatchesCondition->check());
    }
}
