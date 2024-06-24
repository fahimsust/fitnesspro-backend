<?php

namespace Tests\Unit\Domain\Affiliates\Models;

use Domain\Accounts\Models\Account;
use Domain\Addresses\Models\Address;
use Domain\Affiliates\Models\Affiliate;
use Tests\UnitTestCase;

class AffiliateTest extends UnitTestCase
{
    private Affiliate $affiliate;

    protected function setUp(): void
    {
        parent::setUp();

        $this->affiliate = Affiliate::factory()->create();
    }

    /** @test */
    public function can_get_linked_account()
    {
        $this->affiliate->update([
            'account_id' => $this->createTestAccount()->id
        ]);

        $this->assertInstanceOf(Account::class, $this->affiliate->account);
    }

    /** @test */
    public function can_get_address()
    {
        $this->assertInstanceOf(Address::class, $this->affiliate->address);
    }
}
