<?php


namespace Tests\Feature\Domain\Payments\Services\PaypalCheckout\Actions;


use Domain\Payments\Models\PaymentMethod;
use Domain\Payments\Services\PaypalCheckout\Actions\Order\CreateSimpleOrder;
use Domain\Payments\Services\PaypalCheckout\Actions\Order\GetOrder;
use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Link;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Domain\Payments\Services\PaypalCheckout\Enums\PaymentIntents;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;

class GetOrderTest extends \Tests\TestCase
{
    use UsesPaypalCheckoutApiClient;

    /** @test */
    public function can_get()
    {
//        Http::allowStrayRequests();

        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","intent":"CAPTURE","status":"APPROVED","payment_source":{"paypal":{"email_address":"john-buyer@782media.com","account_id":"QRVLX72Q3CVHE","account_status":"VERIFIED","name":{"given_name":"test","surname":"buyer"},"address":{"country_code":"US"}}},"purchase_units":[{"reference_id":"test-capture","amount":{"currency_code":"USD","value":"1.00"},"payee":{"email_address":"sb-lwwxc28936856@business.example.com","merchant_id":"FQULKU6RVXEQS"},"soft_descriptor":"TEST STORE","shipping":{"name":{"full_name":"test buyer"},"address":{"address_line_1":"1 Main St","admin_area_2":"San Jose","admin_area_1":"CA","postal_code":"95131","country_code":"US"}}}],"payer":{"name":{"given_name":"test","surname":"buyer"},"email_address":"john-buyer@782media.com","payer_id":"QRVLX72Q3CVHE","address":{"country_code":"US"}},"create_time":"2023-12-28T18:21:39Z","links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"update","method":"PATCH"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R/capture","rel":"capture","method":"POST"}]}
JSON, 200);

//        Client::$dumpResponse = true;

//        $this->initClient();
//        GenerateNewAccessToken::now($this->apiClient);
        $this->initPaypalClient("A21AAJrQt3Hn7oukhg6zJxmCKDHqMB1_TlS3f-M9tv0NSt3XpTlKsgUyRCWpBeKRyaVlFIKYcyYyr-DF4rRKg7xRfFeWY06sQ");

        $order = GetOrder::now(
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
