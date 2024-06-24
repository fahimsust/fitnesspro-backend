<?php


namespace Tests\Feature\Domain\Accounts\Jobs\Membership;



use Domain\Accounts\Jobs\Membership\UpdateMembershipStatusForExpiredMemberships;
use Domain\Accounts\Models\Membership\Subscription;
use function now;

class UpdateMembershipStatusTest extends \Tests\TestCase
{
    /** @test */
    public function can()
    {
        $this->createTestAccount()
            ->update(['membership_status' => true]);

        UpdateMembershipStatusForExpiredMemberships::dispatchSync();

        $this->assertFalse($this->account->fresh()->membership_status);

    }

    /** @test */
    public function can_ignore_if_new_membership()
    {
        $this->createTestAccount()
            ->update(['membership_status' => true]);

        Subscription::factory([
            'account_id' => $this->account->id,
            'start_date' => now(),
            'end_date' => now()->addYear()
        ])->create();

        UpdateMembershipStatusForExpiredMemberships::dispatchSync();

        $this->assertTrue($this->account->fresh()->membership_status);
    }
}
