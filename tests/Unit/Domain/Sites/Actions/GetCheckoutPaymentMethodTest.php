<?php

namespace Tests\Unit\Domain\Sites\Actions;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Sites\Actions\PaymentMethods\GetCheckoutPaymentMethod;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SitePaymentMethod;
use Tests\TestCase;


class GetCheckoutPaymentMethodTest extends TestCase
{
    /** @test */
    public function can_get_checkout_payment_method()
    {
        $site = Site::factory()->create();
        $paymentMethod = PaymentMethod::factory()->create();
        $paymentAccount = PaymentAccount::factory()->create();
        SitePaymentMethod::factory()->create();
        $checkoutPaymentMethod = GetCheckoutPaymentMethod::run($site, $paymentMethod->id, $paymentAccount->id);
        $this->assertInstanceOf(SitePaymentMethod::class,$checkoutPaymentMethod);
    }
}
