<?php

namespace Tests\Feature\Domain\Accounts\Jobs\Membership;



use Domain\Accounts\Jobs\Membership\SendRemindersToTrialMemberships;
use Domain\Accounts\Mail\TrialMembershipExpirationReminder1;
use Domain\Accounts\Mail\TrialMembershipExpirationReminder2;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Membership\Subscription;
use Illuminate\Support\Facades\Mail;
use function now;

class SendRemindersToTrialMembershipTest extends \Tests\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->createTestAccount()
            ->update(['membership_status' => true]);
    }

    /** @test */
    public function can_send_reminder_1()
    {
        SendRemindersToTrialMemberships::dispatchSync();

        Mail::assertNothingSent();

        $membership = Subscription::factory([
            'level_id' => MembershipLevel::firstOrFactory([
                'trial' => true
            ]),
            'account_id' => $this->account->id,
            'start_date' => now(),
            'end_date' => now()->addDays(13)
        ])->create();

        $this->assertFalse((bool)$membership->expirealert1_sent);

        SendRemindersToTrialMemberships::dispatchSync();

        $this->assertNotFalse((bool)$membership->fresh()->expirealert1_sent);

        Mail::assertSent(TrialMembershipExpirationReminder1::class);
        Mail::assertNotSent(TrialMembershipExpirationReminder2::class);
    }

    /** @test */
    public function will_ignore_if_expire_alert_1_sent()
    {
        Subscription::factory([
            'level_id' => MembershipLevel::firstOrFactory([
                'trial' => true
            ]),
            'account_id' => $this->account->id,
            'start_date' => now(),
            'end_date' => now()->addDays(13),
            'expirealert1_sent' => now()
        ])->create();

        SendRemindersToTrialMemberships::dispatchSync();

        Mail::assertNothingSent();
    }

    /** @test */
    public function can_send_reminder_2()
    {
        $membership = Subscription::factory([
            'level_id' => MembershipLevel::firstOrFactory([
                'trial' => true
            ]),
            'account_id' => $this->account->id,
            'start_date' => now(),
            'end_date' => now()->addDays(4)
        ])->create();

        $this->assertFalse((bool)$membership->expirealert2_sent);

        SendRemindersToTrialMemberships::dispatchSync();

        $this->assertNotFalse((bool)$membership->fresh()->expirealert2_sent);

        Mail::assertNotSent(TrialMembershipExpirationReminder1::class);
        Mail::assertSent(TrialMembershipExpirationReminder2::class);
    }

    /** @test */
    public function will_ignore_if_expire_alert_2_sent()
    {
        Subscription::factory([
            'level_id' => MembershipLevel::firstOrFactory([
                'trial' => true
            ]),
            'account_id' => $this->account->id,
            'start_date' => now(),
            'end_date' => now()->addDays(4),
            'expirealert2_sent' => now()
        ])->create();

        SendRemindersToTrialMemberships::dispatchSync();

        Mail::assertNothingSent();
    }

    /** @test */
    public function will_ignore_memberships_expiring_before_or_after_target()
    {
        $membership = Subscription::factory([
            'level_id' => MembershipLevel::firstOrFactory([
                'trial' => true
            ]),
            'account_id' => $this->account->id,
            'start_date' => now()->subYear(),
            'end_date' => now()->subDay(),
        ])->create();

        SendRemindersToTrialMemberships::dispatchSync();

        Mail::assertNothingSent();

        $membership->update(['end_date' => now()->addDays(15)]);

        SendRemindersToTrialMemberships::dispatchSync();

        Mail::assertNothingSent();
    }
}
