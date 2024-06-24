<?php


namespace Tests\Feature\Domain\Payments\Services\PaypalCheckout\Actions;


use Domain\Payments\Services\PaypalCheckout\Actions\Order\CaptureOrder;
use Domain\Payments\Services\PaypalCheckout\Actions\Order\GetOrder;
use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;

class CaptureOrderTest extends \Tests\TestCase
{
    use UsesPaypalCheckoutApiClient;

    /** @test */
    public function can()
    {
//        Http::allowStrayRequests();
//
        $this->mockCaptureResponse();

//        Client::$dumpResponse = true;

//        $this->initClient();
//        GenerateNewAccessToken::now($this->apiClient);
        $this->initPaypalClient("A21AAJrQt3Hn7oukhg6zJxmCKDHqMB1_TlS3f-M9tv0NSt3XpTlKsgUyRCWpBeKRyaVlFIKYcyYyr-DF4rRKg7xRfFeWY06sQ");

        $order = CaptureOrder::now(
            $this->paypalApiClient,
            "1788572669270162R"
        );

        $this->assertInstanceOf(Order::class, $order);
//        $this->assertInstanceOf(Link::class, $order->links['payer-action']);
//        $this->assertInstanceOf(Link::class, $order->links['approve']);
    }

    /*
     *
     * {"id":"8U841327JS369511S","status":"CREATED","links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/8U841327JS369511S","rel":"self","method":"GET"},{"href":"https://www.sandbox.paypal.com/checkoutnow?token=8U841327JS369511S","rel":"approve","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/8U841327JS369511S","rel":"update","method":"PATCH"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/8U841327JS369511S/authorize","rel":"authorize","method":"POST"}]}
     */
}
