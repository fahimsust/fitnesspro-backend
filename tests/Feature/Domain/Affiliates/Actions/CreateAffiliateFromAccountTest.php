<?php

namespace Tests\Feature\Domain\Affiliates\Actions;
use Domain\Accounts\Models\Account;
use Domain\Accounts\Models\AccountAddress;
use Domain\Affiliates\Actions\CreateAffiliateFromAccount;
use Domain\Affiliates\Models\Affiliate;
use Tests\TestCase;

class CreateAffiliateFromAccountTest extends TestCase
{
    /** @test */
    public function can_create_affiliate()
    {
        $account = Account::factory()->create();
        $accountAddress = AccountAddress::factory()->create();

        $account->update([
            'default_billing_id' => $accountAddress->id,
        ]);

        $affiliate = CreateAffiliateFromAccount::run($account);

        $this->assertInstanceOf(Affiliate::class, $affiliate);
        $this->assertEquals(1, Affiliate::count());
        $this->assertEquals($account->email, $affiliate->email);
        $this->assertEquals($account->id, $accountAddress->account_id);
    }
}
