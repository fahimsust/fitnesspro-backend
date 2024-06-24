<?php

namespace Tests\Unit\Domain\Sites\Actions;

use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Actions\PaymentMethods\GetSiteSubscriptionPaymentMethod;
use Domain\Sites\Models\Site;
use Tests\TestCase;


class GetSubscriptionPaymentMethodTest extends TestCase
{
    /** @test */
    public function can_get_subscription_payment_method_for_site()
    {
        $site = Site::factory()->create();
        $paymentMethod = PaymentMethod::factory()->create();
        $paymentAccount = PaymentAccount::factory()->create();
        SubscriptionPaymentOption::factory()->create(['payment_method_id' => $paymentMethod->id]);
        $subscriptionPayment = GetSiteSubscriptionPaymentMethod::run($site, $paymentMethod->id, $paymentAccount->id);
        $this->assertInstanceOf(SubscriptionPaymentOption::class,$subscriptionPayment);
    }
}
