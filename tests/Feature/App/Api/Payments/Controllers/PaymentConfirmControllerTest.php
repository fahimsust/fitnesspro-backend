<?php

namespace Tests\Feature\App\Api\Payments\Controllers;

use Domain\Orders\Enums\Order\OrderTransactionStatuses;
use Domain\Orders\Models\Order\Transactions\OrderTransaction;
use Domain\Payments\Enums\PaymentMethodActions;
use Domain\Payments\Jobs\PaypalCheckout\CapturePaypalPayment;
use Domain\Payments\Models\PaymentMethod;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;
use Tests\TestCase;
use function route;

class PaymentConfirmControllerTest extends TestCase
{
    use UsesPaypalCheckoutApiClient;

    /** @test */
    public function can()
    {
        \Queue::fake([
            CapturePaypalPayment::class
        ]);

        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","intent":"CAPTURE","status":"APPROVED","payment_source":{"paypal":{"email_address":"john-buyer@782media.com","account_id":"QRVLX72Q3CVHE","account_status":"VERIFIED","name":{"given_name":"test","surname":"buyer"},"address":{"country_code":"US"}}},"purchase_units":[{"reference_id":"test-capture","amount":{"currency_code":"USD","value":"1.00"},"payee":{"email_address":"sb-lwwxc28936856@business.example.com","merchant_id":"FQULKU6RVXEQS"},"soft_descriptor":"TEST STORE","shipping":{"name":{"full_name":"test buyer"},"address":{"address_line_1":"1 Main St","admin_area_2":"San Jose","admin_area_1":"CA","postal_code":"95131","country_code":"US"}}}],"payer":{"name":{"given_name":"test","surname":"buyer"},"email_address":"john-buyer@782media.com","payer_id":"QRVLX72Q3CVHE","address":{"country_code":"US"}},"create_time":"2023-12-28T18:21:39Z","links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"update","method":"PATCH"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R/capture","rel":"capture","method":"POST"}]}
JSON, 200);

        $this->createAccount("dummy-token");

        $transaction = OrderTransaction::factory()
            ->for($this->paymentAccount)
            ->create([
                'payment_method_id' => PaymentMethod::factory()
                    ->create([
                        'id' => PaymentMethodActions::PaypalProExpress->value
                    ]),
                'status' => OrderTransactionStatuses::Pending
            ]);

        $result = $this->postJson(route('api.payment.confirm', [
            'order_transaction_id' => $transaction->id,
        ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'transaction' => [
                    'id',
                    'order_id',
                    'payment_method_id',
                    'payment_account_id',
                    'billing_address_id',
                    'amount',
                    'original_amount',
                    'currency',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ]);

        $this->assertEquals(OrderTransactionStatuses::Approved, $transaction->fresh()->status);
        \Queue::assertPushed(CapturePaypalPayment::class);
    }

    /** @test */
    public function can_fail_api()
    {
        \Queue::fake([
            CapturePaypalPayment::class
        ]);

        Http::fakeSequence('*')
            ->push(null, 400);

        $this->createAccount("dummy-token");

        $transaction = OrderTransaction::factory()
            ->for($this->paymentAccount)
            ->create([
                'payment_method_id' => PaymentMethod::factory()
                    ->create([
                        'id' => PaymentMethodActions::PaypalProExpress->value
                    ]),
                'status' => OrderTransactionStatuses::Pending
            ]);

        $this->postJson(route('api.payment.confirm', [
            'order_transaction_id' => $transaction->id,
        ]))
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /** @test */
    public function can_fail_if_not_found()
    {
        $this->postJson(route('api.payment.confirm', [
            'order_transaction_id' => 1,
        ]))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /** @test */
    public function requires_transaction_id()
    {
        $this->postJson(route('api.payment.confirm', [
            'order_transaction_id' => 0,
        ]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrorFor('order_transaction_id')
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }
}
