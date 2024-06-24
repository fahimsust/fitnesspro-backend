<?php

namespace Tests\Feature\Domain\Accounts\Actions\Registration;

use App\Api\Payments\Requests\CimPaymentProfileRequest;
use App\Api\Payments\Requests\PassivePaymentRequest;
use App\Api\Payments\Requests\PaypalCheckoutRequest;
use Domain\Accounts\Actions\Registration\Order\PlaceOrderForRegistration;
use Domain\Accounts\Jobs\Membership\SendSiteMailable;
use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Accounts\Models\Membership\Subscription;
use Domain\Accounts\Models\Membership\SubscriptionPaymentOption;
use Domain\Affiliates\Jobs\CreateAffiliateFromAccount;
use Domain\Orders\Enums\Order\OrderPaymentStatuses;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Enums\PaymentMethodActions;
use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\AuthorizeNet\Actions\MockApiResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use Support\Dtos\RedirectUrl;
use Tests\Feature\Domain\Payments\Services\AuthorizeNet\Traits\UsesAuthorizeNetApiClient;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;
use Tests\Feature\Traits\TestsRegistration;
use Tests\TestCase;

class PlaceOrderForRegistrationTest extends TestCase
{
    use UsesAuthorizeNetApiClient,
        UsesPaypalCheckoutApiClient;
    use TestsRegistration;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Queue::fake();

        $this->createRegistrationReadyToPlaceOrder();
    }

    /** @test */
    public function can_using_passive_payment()
    {
        $this->assertDatabaseCount(Order::Table(), 0);
        $this->assertDatabaseCount(Subscription::Table(), 0);

        $this->registration->update([
            'payment_method_id' => PaymentMethod::find(2, 'id')->id,
        ]);

        SubscriptionPaymentOption::firstOrFactory([
            'site_id' => $this->registration->site_id,
            'payment_method_id' => $this->registration->payment_method_id,
        ]);

        $checkout = PlaceOrderForRegistration::now(
            $this->registration,
            new PassivePaymentRequest()
        );

        $orders = Order::all();
        $this->assertCount(1, $orders);

        $order = $orders->first();
        $this->assertEquals($order->status, OrderStatuses::Completed);
        $this->assertEquals($order->id, $this->registration->order_id);

        $subscriptions = Subscription::all();
        $this->assertCount(1, $subscriptions);

        $subscription = $subscriptions->first();
        $this->assertEquals(
            [
                $this->registration->level_id,
                $this->registration->levelCached()->annual_product_id,
                $order->id
            ],
            [
                $subscription->level_id,
                $subscription->product_id,
                $subscription->order_id
            ]
        );

        $this->assertDatabaseEmpty(OrderTransaction::Table());

        $this->assertTrue(
            $checkout->paymentResult === true
        );

        Queue::assertPushed(
            CreateAffiliateFromAccount::class,
            fn($job) => $job->account->id === $this->registration->account_id
        );

        Queue::assertPushed(
            SendSiteMailable::class,
            fn($job) => $job->site->id === $this->registration->site_id
                && $job->mailable->keyHandler->order->id === $order->id
                && $job->mailable->account->id === $this->registration->account_id
        );
    }

    /** @test */
    public function can_using_jumping_method()
    {
        $this->mockCreateOrderResponse();
        $this->assertDatabaseCount(Order::Table(), 0);

        $this->createAccount("dummy-token");

        $this->registration->update([
            'payment_method_id' => PaymentMethodActions::PaypalProExpress->value,
        ]);

        SubscriptionPaymentOption::where(
            'payment_method_id',
            $this->registration->payment_method_id
        )
            ->where(
                'site_id',
                $this->registration->site_id
            )
            ->update([
                'gateway_account_id' => $this->paymentAccount->id,
            ]);

        $checkout = PlaceOrderForRegistration::now(
            $this->registration,
            new PaypalCheckoutRequest()
        );

        $orders = Order::all();
        $this->assertCount(1, $orders);

        $order = $orders->first();
        $this->assertEquals($order->status, OrderStatuses::Recorded);
        $this->assertEquals($order->payment_status, OrderPaymentStatuses::Pending);
        $this->assertEquals($order->id, $this->registration->order_id);

        $this->assertDatabaseCount(OrderTransaction::Table(), 1);
        $transaction = OrderTransaction::first();
        $this->assertEquals($transaction->order_id, $order->id);
        $this->assertEquals($transaction->status, OrderTransactionStatuses::Pending);

        $this->assertInstanceOf(
            RedirectUrl::class,
            $checkout->paymentResult,
        );
        $this->assertEquals(
            $checkout->paymentResult->url,
            $this->payerActionUrl
        );
    }

    /** @test */
    public function can_using_nonjumping_method()
    {
        $this->mockExecuteApi()
            ->once()
            ->andReturn(MockApiResponse::now(
                new CreateTransactionResponse,
                <<<EOD
{"transactionResponse":{"responseCode":"1","authCode":"000000","avsResultCode":"Y","cvvResultCode":"P","cavvResultCode":"2","transId":"40109582555","refTransID":"","transHash":"","testRequest":"0","accountNumber":"XXXX0015","accountType":"MasterCard","messages":[{"code":"1","description":"This transaction has been approved."}],"transHashSha2":"","profile":{"customerProfileId":"508168897","customerPaymentProfileId":"513137419"},"SupplementalDataQualificationIndicator":0,"networkTransId":"00000000000000000000000"},"refId":"TEST-REF-001","messages":{"resultCode":"Ok","message":[{"code":"I00001","text":"Successful."}]}}
EOD
            ));

        $this->assertDatabaseCount(Order::Table(), 0);

        $this->registration->update([
            'payment_method_id' => 1,
        ]);

        SubscriptionPaymentOption::firstOrFactory([
            'site_id' => $this->registration->site_id,
            'payment_method_id' => $this->registration->payment_method_id,
        ]);

        $paymentProfile = CimPaymentProfile::firstOrFactory([
            'cc_exp' => now()->addDays(60)
        ]);

        $checkout = PlaceOrderForRegistration::now(
            $this->registration,
            new CimPaymentProfileRequest([
                'payment_profile_id' => $paymentProfile->id,
            ])
        );

        $orders = Order::all();
        $this->assertCount(1, $orders);

        $order = $orders->first();
        $this->assertEquals($order->status, OrderStatuses::Completed);
        $this->assertEquals($order->id, $this->registration->order_id);

        $this->assertInstanceOf(
            OrderTransaction::class,
            $checkout->paymentResult,
        );

        $transactions = OrderTransaction::all();
        $this->assertCount(1, $transactions);

        $transaction = $transactions->first();
        $this->assertEquals($transaction->order_id, $order->id);
        $this->assertEquals('40109582555', $transaction->transaction_no);

        Queue::assertPushed(
            SendSiteMailable::class,
            fn($job) => $job->site->id === $this->registration->site_id
                && $job->mailable->keyHandler->order->id === $order->id
                && $job->mailable->account->id === $this->registration->account_id
        );
    }
}
