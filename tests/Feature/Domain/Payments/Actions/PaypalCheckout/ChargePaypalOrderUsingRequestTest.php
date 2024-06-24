<?php


namespace Tests\Feature\Domain\Payments\Actions\PaypalCheckout;


use App\Api\Payments\Contracts\PaymentRequest;
use Domain\Orders\Enums\Order\OrderStatuses;
use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Order;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Actions\Services\PaypalCheckout\ChargePaypalOrderPaymentServiceAction;
use Domain\Payments\Dtos\PaymentRequestData;
use Domain\Payments\Jobs\PaypalCheckout\AuthorizePaypalPayment;
use Domain\Payments\Jobs\PaypalCheckout\CapturePaypalPayment;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Support\Dtos\RedirectUrl;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;

class ChargePaypalOrderUsingRequestTest extends \Tests\TestCase
{
    use UsesPaypalCheckoutApiClient;

    private PaymentMethod $paymentMethod;

    protected function setUp(): void
    {
        parent::setUp();

        Queue::fake([
            CapturePaypalPayment::class,
            AuthorizePaypalPayment::class,
        ]);

        $this->createAccount(
            "A21AAJSxDmFuN9wfkC2S8-Unof8NkRj7CgfqMw2MlVWbJu1t0FjP-H6cXRTKDiJFmbB7aQ6mi3bmtC9dwBN-q7ct0nAy-BsIA"
        );
        $this->paymentMethod = PaymentMethod::firstOrFactory();
    }

    /** @test */
    public function can_jump()
    {
        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","status":"PAYER_ACTION_REQUIRED","payment_source":{"paypal":{}},"links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"},{"href":"https://www.sandbox.paypal.com/checkoutnow?token=1788572669270162R","rel":"payer-action","method":"GET"}]}
JSON
            );

        $this->assertDatabaseCount(OrderTransaction::Table(), 0);

        $result = (new ChargePaypalOrderPaymentServiceAction(
            new PaymentRequestData(
                order: Order::firstOrFactory([
                    'status' => OrderStatuses::Recorded
                ]),
                request: new PaymentRequest(),
                account: $this->paymentAccount,
                method: $this->paymentMethod,
                amount: 1.00,
            )
        ))
            ->jump();

        $this->assertInstanceOf(RedirectUrl::class, $result);
        $this->assertEquals($result->url, "https://www.sandbox.paypal.com/checkoutnow?token=1788572669270162R");

        $this->assertDatabaseCount(OrderTransaction::Table(), 1);
        $this->assertDatabaseHas(OrderTransaction::Table(), [
            'order_id' => Order::first()->id,
            'transaction_no' => '1788572669270162R',
            'gateway_account_id' => $this->paymentAccount->id,
            'payment_method_id' => $this->paymentMethod->id,
            'amount' => "1.00",
            'status' => OrderTransactionStatuses::Pending,
        ]);
//        dd($transactionDto);
    }


    /** @test */
    public function can_confirm_capture()
    {

        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","intent":"CAPTURE","status":"APPROVED","payment_source":{"paypal":{"email_address":"john-buyer@782media.com","account_id":"QRVLX72Q3CVHE","account_status":"VERIFIED","name":{"given_name":"test","surname":"buyer"},"address":{"country_code":"US"}}},"purchase_units":[{"reference_id":"test-capture","amount":{"currency_code":"USD","value":"1.00"},"payee":{"email_address":"sb-lwwxc28936856@business.example.com","merchant_id":"FQULKU6RVXEQS"},"soft_descriptor":"TEST STORE","shipping":{"name":{"full_name":"test buyer"},"address":{"address_line_1":"1 Main St","admin_area_2":"San Jose","admin_area_1":"CA","postal_code":"95131","country_code":"US"}}}],"payer":{"name":{"given_name":"test","surname":"buyer"},"email_address":"john-buyer@782media.com","payer_id":"QRVLX72Q3CVHE","address":{"country_code":"US"}},"create_time":"2023-12-28T18:21:39Z","links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"update","method":"PATCH"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R/capture","rel":"capture","method":"POST"}]}
JSON, 200);

        $transaction = OrderTransaction::factory()
            ->create([
                'transaction_no' => '1788572669270162R',
                'gateway_account_id' => $this->paymentAccount->id,
                'payment_method_id' => $this->paymentMethod->id,
                'amount' => "1.00",
                'status' => OrderTransactionStatuses::Pending,
            ]);
        $this->assertDatabaseCount(OrderTransaction::Table(), 1);

        $result = (new ChargePaypalOrderPaymentServiceAction(
            new PaymentRequestData(
                order: $transaction->order,
                request: new PaymentRequest(),
                account: $this->paymentAccount,
                method: $this->paymentMethod,
                amount: 1.00,
                transaction: $transaction,
            )
        ))
            ->confirm();

        $this->assertDatabaseCount(OrderTransaction::Table(), 1);
        $this->assertInstanceOf(OrderTransaction::class, $result);
        $this->assertEquals($result->status, OrderTransactionStatuses::Approved);
        $this->assertEquals($result->transaction_no, "1788572669270162R");

        Queue::assertPushed(CapturePaypalPayment::class);
    }


    /** @test */
    public function can_confirm_authorize()
    {
        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","intent":"AUTHORIZE","status":"APPROVED","payment_source":{"paypal":{"email_address":"john-buyer@782media.com","account_id":"QRVLX72Q3CVHE","account_status":"VERIFIED","name":{"given_name":"test","surname":"buyer"},"address":{"country_code":"US"}}},"purchase_units":[{"reference_id":"test-capture","amount":{"currency_code":"USD","value":"1.00"},"payee":{"email_address":"sb-lwwxc28936856@business.example.com","merchant_id":"FQULKU6RVXEQS"},"soft_descriptor":"TEST STORE","shipping":{"name":{"full_name":"test buyer"},"address":{"address_line_1":"1 Main St","admin_area_2":"San Jose","admin_area_1":"CA","postal_code":"95131","country_code":"US"}}}],"payer":{"name":{"given_name":"test","surname":"buyer"},"email_address":"john-buyer@782media.com","payer_id":"QRVLX72Q3CVHE","address":{"country_code":"US"}},"create_time":"2023-12-28T18:21:39Z","links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"update","method":"PATCH"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R/capture","rel":"capture","method":"POST"}]}
JSON, 200);

        $transaction = OrderTransaction::factory()
            ->create([
                'transaction_no' => '1788572669270162R',
                'gateway_account_id' => $this->paymentAccount->id,
                'payment_method_id' => $this->paymentMethod->id,
                'amount' => "1.00",
                'status' => OrderTransactionStatuses::Pending,
            ]);
        $this->assertDatabaseCount(OrderTransaction::Table(), 1);

        $result = (new ChargePaypalOrderPaymentServiceAction(
            new PaymentRequestData(
                order: $transaction->order,
                request: new PaymentRequest(),
                account: $this->paymentAccount,
                method: $this->paymentMethod,
                amount: 1.00,
                transaction: $transaction,
            )
        ))
            ->confirm();

        $this->assertDatabaseCount(OrderTransaction::Table(), 1);
        $this->assertInstanceOf(OrderTransaction::class, $result);
        $this->assertEquals($result->status, OrderTransactionStatuses::Approved);
        $this->assertEquals($result->transaction_no, "1788572669270162R");

        Queue::assertPushed(AuthorizePaypalPayment::class);
    }
}
