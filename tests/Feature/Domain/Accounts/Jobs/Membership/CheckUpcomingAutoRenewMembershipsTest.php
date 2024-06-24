<?php


namespace Tests\Feature\Domain\Accounts\Jobs\Membership;



use Domain\Accounts\Jobs\Membership\CheckUpcomingAutoRenewMemberships;
use Domain\Accounts\Mail\MembershipWillAutoRenewIn30Days;
use Domain\Accounts\Mail\UpdateCardExpirationForAutoRenewal;
use Domain\Accounts\Mail\UpdatePaymentSetupForAutoRenewal;
use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Support\Facades\Mail;
use function now;

class CheckUpcomingAutoRenewMembershipsTest extends \Tests\TestCase
{
    private ?PaymentMethod $paymentMethod;
    private ?CimPaymentProfile $paymentProfile;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->createTestAccount()
            ->update(['membership_status' => true]);

        $this->paymentMethod = PaymentMethod::firstOrFactory();
        $this->paymentProfile = CimPaymentProfile::firstOrFactory();
    }

    /** @test */
    public function can_check_and_send_to_found()
    {
        CheckUpcomingAutoRenewMemberships::dispatchSync();

        Mail::assertNothingSent();//nothing sent when no membership record

        $this->paymentProfile->update(['cc_exp' => now()->addDays(60)]);

        $this->createMembership();

        CheckUpcomingAutoRenewMemberships::dispatchSync();

        Mail::assertSent(MembershipWillAutoRenewIn30Days::class);
    }

    /** @test */
    public function can_alert_if_invalid_payment_method()
    {
        $this->paymentMethod = null;
        $this->createMembership();

        CheckUpcomingAutoRenewMemberships::dispatchSync();

        Mail::assertSent(UpdatePaymentSetupForAutoRenewal::class);
    }

    /** @test */
    public function can_alert_if_invalid_payment_profile()
    {
        $this->paymentProfile = null;
        $this->createMembership();

        CheckUpcomingAutoRenewMemberships::dispatchSync();

        Mail::assertSent(UpdatePaymentSetupForAutoRenewal::class);
    }

    /** @test */
    public function can_alert_expiring_card()
    {
        $this->createMembership();

        CheckUpcomingAutoRenewMemberships::dispatchSync();

        Mail::assertSent(UpdateCardExpirationForAutoRenewal::class);
    }

    protected function createMembership(): Subscription
    {
        return Subscription::factory([
            'level_id' => MembershipLevel::firstOrFactory(),
            'account_id' => $this->account->id,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'auto_renew' => 1,
            'renew_payment_method' => $this->paymentMethod,
            'renew_payment_profile_id' => $this->paymentProfile
        ])->create();
    }
}
