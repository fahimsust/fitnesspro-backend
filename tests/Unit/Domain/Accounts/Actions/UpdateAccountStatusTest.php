<?php

namespace Tests\Unit\Domain\Accounts\Actions;

use Domain\Accounts\Actions\UpdateAccountStatus;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountStatus;
use Tests\TestCase;


class UpdateAccountStatusTest extends TestCase
{
    /** @test */
    public function can_update_account_type()
    {
        $accountStatus = AccountStatus::factory()->create();
        $account = Account::factory()->create(['type_id' => $accountStatus->id]);
        $updatedAccountStatus = AccountStatus::factory()->create();

        UpdateAccountStatus::run($account, $updatedAccountStatus->id);
        $this->assertEquals($updatedAccountStatus->id, $account->refresh()->status_id);
    }
}
