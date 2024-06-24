<?php


namespace Tests\Feature\Domain\Accounts\Jobs\Membership;



use Domain\Accounts\Jobs\Membership\AutoRenewMembership;
use Domain\Accounts\Jobs\Membership\ManageAutoRenewMembershipsExpiringTomorrow;
use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\Feature\Traits\MembershipJobData;
use function now;

class ManageAutoRenewMembershipsExpiringTomorrowTest extends \Tests\TestCase
{
    use MembershipJobData;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Queue::fake();

        $this->seedMembershipData();

        $this->createTestAccount()
            ->update(['membership_status' => true]);

        $this->paymentMethod = PaymentMethod::firstOrFactory();
        $this->paymentProfile = CimPaymentProfile::firstOrFactory();
    }

    /** @test */
    public function will_not_dispatch_when_no_results()
    {
        (new ManageAutoRenewMembershipsExpiringTomorrow)->handle();

        Queue::assertNothingPushed();
    }

    /** @test */
    public function can_check_and_dispatch_found()
    {
        $this->paymentProfile->update([
            'cc_exp' => now()->addDays(60)
        ]);

        $this->createMembership();

        (new ManageAutoRenewMembershipsExpiringTomorrow)->handle();

        Queue::assertPushed(AutoRenewMembership::class);
    }

    /** @test */
    public function can_ignore_not_expiring_tomorrow()
    {
        $this->paymentProfile->update([
            'cc_exp' => now()->addDays(60)
        ]);

        $this->createMembership(2);

        (new ManageAutoRenewMembershipsExpiringTomorrow)->handle();

        Queue::assertNothingPushed();
    }

    protected function createMembership(int $addDays = 1): Subscription
    {
        return Subscription::factory([
            'level_id' => MembershipLevel::firstOrFactory(),
            'account_id' => $this->account->id,
            'start_date' => now(),
            'end_date' => now()->addDays($addDays),
            'auto_renew' => 1,
            'renew_payment_method' => $this->paymentMethod,
            'renew_payment_profile_id' => $this->paymentProfile
        ])->create();
    }
}
