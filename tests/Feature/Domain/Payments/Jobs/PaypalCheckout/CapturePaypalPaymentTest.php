<?php


namespace Tests\Feature\Domain\Payments\Jobs\PaypalCheckout;


use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\OrderActivity;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Jobs\PaypalCheckout\CapturePaypalPayment;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;

class CapturePaypalPaymentTest extends \Tests\TestCase
{
    use UsesPaypalCheckoutApiClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAccount(
            "A21AAJSxDmFuN9wfkC2S8-Unof8NkRj7CgfqMw2MlVWbJu1t0FjP-H6cXRTKDiJFmbB7aQ6mi3bmtC9dwBN-q7ct0nAy-BsIA"
        );
    }

    /** @test */
    public function can()
    {
        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","status":"COMPLETED","payment_source":{"paypal":{"email_address":"john-buyer@782media.com","account_id":"QRVLX72Q3CVHE","account_status":"VERIFIED","name":{"given_name":"test","surname":"buyer"},"address":{"country_code":"US"}}},"purchase_units":[{"reference_id":"test-capture","shipping":{"name":{"full_name":"test buyer"},"address":{"address_line_1":"1 Main St","admin_area_2":"San Jose","admin_area_1":"CA","postal_code":"95131","country_code":"US"}},"payments":{"captures":[{"id":"8R261647WV282751T","status":"COMPLETED","amount":{"currency_code":"USD","value":"1.00"},"final_capture":true,"disbursement_mode":"INSTANT","seller_protection":{"status":"ELIGIBLE","dispute_categories":["ITEM_NOT_RECEIVED","UNAUTHORIZED_TRANSACTION"]},"seller_receivable_breakdown":{"gross_amount":{"currency_code":"USD","value":"1.00"},"paypal_fee":{"currency_code":"USD","value":"0.52"},"net_amount":{"currency_code":"USD","value":"0.48"}},"links":[{"href":"https://api.sandbox.paypal.com/v2/payments/captures/8R261647WV282751T","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/payments/captures/8R261647WV282751T/refund","rel":"refund","method":"POST"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"up","method":"GET"}],"create_time":"2023-12-28T19:26:28Z","update_time":"2023-12-28T19:26:28Z"}]}}],"payer":{"name":{"given_name":"test","surname":"buyer"},"email_address":"john-buyer@782media.com","payer_id":"QRVLX72Q3CVHE","address":{"country_code":"US"}},"links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"}]}
JSON
            );

        $transaction = OrderTransaction::factory()
            ->create([
                'transaction_no' => "1788572669270162R",
                'status' => OrderTransactionStatuses::Pending,
            ]);

        $this->assertDatabaseCount(OrderActivity::Table(), 0);

        CapturePaypalPayment::dispatch(
            $transaction->id
        );

        $this->assertEquals(OrderTransactionStatuses::Captured, $transaction->fresh()->status);
        $this->assertDatabaseCount(OrderActivity::Table(), 1);
    }

    /** @test */
    public function can_fail()
    {
        Http::fakeSequence('*')
            ->push(null, 400);

        $transaction = OrderTransaction::factory()
            ->create([
                'transaction_no' => "1788572669270162R",
                'status' => OrderTransactionStatuses::Pending,
            ]);

        $this->assertDatabaseCount(OrderActivity::Table(), 0);

        try {
            $this->expectException(RequestException::class);

            CapturePaypalPayment::dispatch(
                $transaction->id
            );
        } finally {
            $this->assertEquals(OrderTransactionStatuses::Pending, $transaction->fresh()->status);
            $this->assertDatabaseCount(OrderActivity::Table(), 1);
        }
    }
}
