<?php

namespace Tests\Unit\Domain\Accounts\Models;

use Database\Seeders\AccountMembershipLevelSeeder;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Membership\Subscription;
use Tests\UnitTestCase;

class AccountMembershipTest extends UnitTestCase
{
    private Subscription $accountMembership;

    protected function setUp(): void
    {
        parent::setUp();

//        $this->seed([AccountMembershipLevelSeeder::class]);
        $this->accountMembership = Subscription::factory()->create();
    }

    /** @test */
    public function can_get_membership_level()
    {
        $this->assertInstanceOf(MembershipLevel::class, $this->accountMembership->level);
    }
}
