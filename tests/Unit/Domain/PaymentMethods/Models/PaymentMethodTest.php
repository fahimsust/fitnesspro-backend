<?php

namespace Tests\Unit\Domain\PaymentMethods\Models;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Tests\UnitTestCase;

class PaymentMethodTest extends UnitTestCase
{
    private PaymentMethod $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();

        Site::firstOrFactory(['id' => config('site.id')]);

        $this->paymentMethod = PaymentMethod::factory()->create();
    }

    /** @test */
    public function can_get_active()
    {
        $this->assertEquals(
            1,
            $this->paymentMethod->active()->count()
        );

        $this->paymentMethod->update(['status' => false]);

        $this->assertEquals(
            0,
            $this->paymentMethod->active()->count()
        );
    }

    /** @test */
    public function can_get_checkout_options()
    {
        SitePaymentMethod::factory()->create([
            'site_id' => config('site.id'),
            'payment_method_id' => PaymentMethod::factory(['status' => false]),
            'gateway_account_id' => PaymentAccount::factory(),
        ]);

        SitePaymentMethod::factory(3)->create([
            'site_id' => config('site.id'),
            'payment_method_id' => PaymentMethod::factory(),
            'gateway_account_id' => PaymentAccount::factory(),
        ]);

        $checkoutOptions = PaymentMethod::checkoutOptions(config('site.id'))
            ->get();

        $this->assertEquals(4, SitePaymentMethod::count());
        $this->assertEquals(
            3,
            $checkoutOptions->count()
        );
        $this->assertInstanceOf(PaymentMethod::class, $checkoutOptions->first());
    }

    /** @test */
    public function can_get_subscription_options()
    {
        SubscriptionPaymentOption::factory()->create([
            'site_id' => config('site.id'),
            'payment_method_id' => PaymentMethod::factory(['status' => false]),
            'gateway_account_id' => PaymentAccount::factory()
        ]);

        SubscriptionPaymentOption::factory(3)->create([
            'site_id' => config('site.id'),
            'payment_method_id' => PaymentMethod::factory(),
            'gateway_account_id' => PaymentAccount::factory()
        ]);

        $subscriptionOptions = PaymentMethod::subscriptionOptions(config('site.id'))
            ->get();

        $this->assertEquals(4, SubscriptionPaymentOption::count());
        $this->assertEquals(
            3,
            $subscriptionOptions->count()
        );
        $this->assertInstanceOf(PaymentMethod::class, $subscriptionOptions->first());
    }
}
