<?php

namespace Tests\Unit\Domain\Accounts\Actions;

use Domain\Accounts\Actions\UpdateAccountType;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountType;
use Tests\TestCase;


class UpdateAccountTypeTest extends TestCase
{
    /** @test */
    public function can_update_account_type()
    {
        $accountType = AccountType::factory()->create();
        $account = Account::factory()->create(['type_id' => $accountType->id]);
        $updatedAccountType = AccountType::factory()->create();

        UpdateAccountType::run($account, $updatedAccountType->id);
        $this->assertEquals($updatedAccountType->id, $account->refresh()->type_id);
    }
}
