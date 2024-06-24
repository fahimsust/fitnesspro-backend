<?php

namespace Tests\Feature\Domain\Accounts\Jobs\Membership;


use Domain\Accounts\Exceptions\CreditCardException;
use Domain\Accounts\Jobs\Membership\AutoRenewMembership;
use Domain\Accounts\Mail\MembershipAutoRenewalFailed;
use Domain\Accounts\Mail\MembershipHasBeenAutoRenewed;
use Domain\Accounts\Models\AccountAddress;
use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Accounts\Models\Membership\MembershipLevel;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Affiliates\Enums\ReferralType;
use Domain\Affiliates\Models\Affiliate;
use Domain\Affiliates\Models\Referral;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\OrderItems\OrderItem;
use Domain\Orders\Models\Order\Shipments\OrderPackage;
use Domain\Orders\Models\Order\Shipments\Shipment;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\AuthorizeNet\Actions\MockApiResponse;
use Domain\Payments\Services\AuthorizeNet\Exceptions\ApiException;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Domain\Products\Models\Product\ProductPricing;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteSettings;
use Illuminate\Support\Facades\Mail;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use Tests\Feature\Domain\Payments\Services\AuthorizeNet\Traits\UsesAuthorizeNetApiClient;
use Tests\Feature\Traits\MembershipJobData;
use function now;

class AutoRenewMembershipTest extends \Tests\TestCase
{
    use UsesAuthorizeNetApiClient,
        MembershipJobData;

    protected Product $product;
    protected Subscription $existingMembership;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        //        Queue::fake();

        $this->seedMembershipData();

        $this->paymentAccount = PaymentAccount::firstOrFactory([
            'login_id' => '2s5Ra8BcZL',
            'transaction_key' => '9xwKUS277c5pTR47',
            'use_test' => true
        ]);

        $this->paymentMethod = PaymentMethod::firstOrFactory();
        $this->paymentProfile = CimPaymentProfile::firstOrFactory();
        SubscriptionPaymentOption::firstOrFactory([
            'payment_method_id' => $this->paymentMethod->id,
        ]);

        $this->createTestAccount()
            ->update(['membership_status' => true]);

        $affiliate = Affiliate::factory([
            'account_id' => $this->account->id
        ])->create();

        $this->account->update([
            'affiliate_id' => Affiliate::factory()->create([
                'affiliate_level_id' => 3
            ])->id
        ]);

        $this->paymentProfile->update([
            'cc_exp' => now()->addDays(60)
        ]);

        $this->existingMembership = $this->createMembership();

        ProductPricing::firstOrFactory([
            'product_id' => $this->product->id,
            'site_id' => app(Site::class)->id
        ]);

        $this->assertDatabaseCount(Order::table(), 1);

        ProductDistributor::factory()
            ->for($this->product)
            ->create();

        SiteSettings::factory()
            ->create([
                'site_id' => app(Site::class)->id
            ]);
    }

    /** @test */
    public function can_auto_renew()
    {
        $this->withoutExceptionHandling();
        $this->mockExecuteApi()
            ->once()
            ->andReturn(MockApiResponse::now(
                new CreateTransactionResponse,
                <<<EOD
{"transactionResponse":{"responseCode":"1","authCode":"000000","avsResultCode":"Y","cvvResultCode":"P","cavvResultCode":"2","transId":"40109582555","refTransID":"","transHash":"","testRequest":"0","accountNumber":"XXXX0015","accountType":"MasterCard","messages":[{"code":"1","description":"This transaction has been approved."}],"transHashSha2":"","profile":{"customerProfileId":"508168897","customerPaymentProfileId":"513137419"},"SupplementalDataQualificationIndicator":0,"networkTransId":"00000000000000000000000"},"refId":"TEST-REF-001","messages":{"resultCode":"Ok","message":[{"code":"I00001","text":"Successful."}]}}
EOD
            ));

        $this->assertDatabaseCount(Order::table(), 1);

        $this->account->update([
            'default_billing_id' => AccountAddress::factory()->create(['account_id' => $this->account->id])->id,
            'default_shipping_id' => AccountAddress::factory()->create(['account_id' => $this->account->id])->id,
        ]);

        AutoRenewMembership::dispatchSync($this->account);

        $this->assertDatabaseCount(Order::table(), 2);
        $this->assertDatabaseCount(Shipment::table(), 1);
        $this->assertDatabaseCount(OrderTransaction::table(), 1);
        $this->assertDatabaseCount(OrderPackage::table(), 1);
        $this->assertDatabaseCount(OrderItem::table(), 1);

        $referrals = Referral::all();
        $this->assertCount(2, $referrals);

        $this->assertTrue(
            $referrals->contains(
                fn (Referral $referral) => $referral->type_id == ReferralType::SUBSCRIPTION
                    && $referral->affiliate_id == $this->account->linkedAffiliate->id
                    && $referral->amount == 2500
            )
        );

        $this->assertTrue(
            $referrals->contains(
                fn (Referral $referral) => $referral->type_id == ReferralType::SUBSCRIPTION
                    && $referral->affiliate_id == $this->account->affiliate_id
                    && $referral->amount > 0
            )
        );

        $memberships = $this->account->memberships;
        $this->assertCount(2, $memberships);

        $activeMembership = $this->account->activeMembership()->get();
        $this->assertCount(1, $activeMembership);
        $this->assertEquals($this->existingMembership->id, $activeMembership->first()->id);

        $newMembership = $memberships->skip(1)->first();
        $this->assertNotEquals($this->existingMembership->id, $newMembership->id);
        $this->assertTrue($this->existingMembership->end_date->addSecond() == $newMembership->start_date);
        $this->assertTrue($newMembership->start_date > now());

        Mail::assertSent(MembershipHasBeenAutoRenewed::class);
    }

    /** @test */
    public function can_handle_failed_payment()
    {
        $this->mockExecuteApi()
            ->once()
            ->andReturn(MockApiResponse::now(
                new CreateTransactionResponse,
                <<<EOD
{"transactionResponse":{"SupplementalDataQualificationIndicator":0},"refId":"ORD001","messages":{"resultCode":"Error","message":[{"code":"E00040","text":"Customer Profile ID or Customer Payment Profile ID not found."}]}}
EOD
            ));

        try {
            $this->expectException(ApiException::class);

            AutoRenewMembership::dispatchSync($this->account);
        } finally {
            $this->assertDatabaseCount(Order::table(), 1);
            $this->assertDatabaseCount(Shipment::table(), 0);
            $this->assertDatabaseCount(OrderTransaction::table(), 0);
            $this->assertDatabaseCount(OrderPackage::table(), 0);
            $this->assertDatabaseCount(OrderItem::table(), 0);

            $memberships = $this->account->memberships;
            $this->assertCount(1, $memberships);

            Mail::assertSent(MembershipAutoRenewalFailed::class);
        }
    }

    /** @test */
    public function can_handle_validation_error()
    {
        $this->paymentProfile->update([
            'cc_exp' => now()->subDay()
        ]);

        try {
            $this->expectException(CreditCardException::class);

            AutoRenewMembership::dispatchSync($this->account);
        } finally {
            $this->assertDatabaseCount(Order::table(), 1);
            $this->assertDatabaseCount(Shipment::table(), 0);
            $this->assertDatabaseCount(OrderTransaction::table(), 0);
            $this->assertDatabaseCount(OrderPackage::table(), 0);
            $this->assertDatabaseCount(OrderItem::table(), 0);

            $memberships = $this->account->memberships;
            $this->assertCount(1, $memberships);

            Mail::assertSent(MembershipAutoRenewalFailed::class);
        }
    }

    protected function createMembership(int $addDays = 1): Subscription
    {
        $level = MembershipLevel::with('product')
            ->firstWhere('name', '=', 'Medallion - Auto Renew');

        $this->product = $level->product;

        return Subscription::factory([
            //            'membership_id' => MembershipLevel::firstOrFactory([
            //                'annual_product_id' => $this->product = Product::firstWhere('url_name', 'basic-auto-renew-membership'),
            //                'auto_renewal_of' => MembershipLevel::firstOrFactory(),
            //                'name' => 'Basic (Auto renew)'
            //            ]),
            'level_id' => $level,
            'product_id' => $this->product->id,
            'account_id' => $this->account->id,
            'start_date' => now(),
            'end_date' => now()->addDays($addDays),
            'auto_renew' => 1,
            'renew_payment_method' => $this->paymentMethod,
            'renew_payment_profile_id' => $this->paymentProfile
        ])->create();
    }
}
