<?php


namespace Tests\Feature\Domain\Payments\Services\PaypalCheckout\Actions;


use Domain\Accounts\Models\Cim\CimPaymentProfile;
use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\PaypalCheckout\Actions\GenerateNewAccessToken;
use Domain\Payments\Services\PaypalCheckout\Actions\Order\CreateSimpleOrder;
use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Link;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentIntents;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Illuminate\Support\Facades\Http;
use net\authorize\api\contract\v1\CreateTransactionResponse;
use net\authorize\api\contract\v1\TransactionResponseType;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;

class CreateOrderTest extends \Tests\TestCase
{
    use UsesPaypalCheckoutApiClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentMethod = PaymentMethod::firstOrFactory();
    }

    /** @test */
    public function can_create_capture()
    {
//        Http::allowStrayRequests();
        $this->mockCreateOrderResponse();

//        Client::$dumpResponse = true;

//        $this->initClient();
//        GenerateNewAccessToken::now($this->apiClient);
        $this->initPaypalClient("A21AAJrQt3Hn7oukhg6zJxmCKDHqMB1_TlS3f-M9tv0NSt3XpTlKsgUyRCWpBeKRyaVlFIKYcyYyr-DF4rRKg7xRfFeWY06sQ");

        $order = CreateSimpleOrder::now(
            $this->paypalApiClient,
            PaymentIntents::Capture,
            'test-capture',
            'USD',
            '1.00',
            "https://example.com/return",
            "https://example.com/cancel"
        );

        $this->assertInstanceOf(Order::class, $order);
        $this->assertInstanceOf(Link::class, $order->links['payer-action']);
//        $this->assertInstanceOf(Link::class, $order->links['approve']);
    }

    /*
     *
     * {"id":"8U841327JS369511S","status":"CREATED","links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/8U841327JS369511S","rel":"self","method":"GET"},{"href":"https://www.sandbox.paypal.com/checkoutnow?token=8U841327JS369511S","rel":"approve","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/8U841327JS369511S","rel":"update","method":"PATCH"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/8U841327JS369511S/authorize","rel":"authorize","method":"POST"}]}
     */
}
