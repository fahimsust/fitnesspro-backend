<?php


namespace Tests\Feature\Domain\Payments\Services\PaypalCheckout\Actions;


use Domain\Payments\Services\PaypalCheckout\Actions\Order\AuthorizeOrder;
use Domain\Payments\Services\PaypalCheckout\Actions\Order\GetOrder;
use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\Order;
use Illuminate\Support\Facades\Http;
use Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits\UsesPaypalCheckoutApiClient;

class AuthorizeOrderTest extends \Tests\TestCase
{
    use UsesPaypalCheckoutApiClient;

    /** @test */
    public function can_get()
    {
//        Http::allowStrayRequests();

        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","status":"COMPLETED","payment_source":{"paypal":{"email_address":"john-buyer@782media.com","account_id":"QRVLX72Q3CVHE","account_status":"VERIFIED","name":{"given_name":"test","surname":"buyer"},"address":{"country_code":"US"}}},"purchase_units":[{"reference_id":"test-capture","shipping":{"name":{"full_name":"test buyer"},"address":{"address_line_1":"1 Main St","admin_area_2":"San Jose","admin_area_1":"CA","postal_code":"95131","country_code":"US"}},"payments":{"captures":[{"id":"8R261647WV282751T","status":"COMPLETED","amount":{"currency_code":"USD","value":"1.00"},"final_capture":true,"disbursement_mode":"INSTANT","seller_protection":{"status":"ELIGIBLE","dispute_categories":["ITEM_NOT_RECEIVED","UNAUTHORIZED_TRANSACTION"]},"seller_receivable_breakdown":{"gross_amount":{"currency_code":"USD","value":"1.00"},"paypal_fee":{"currency_code":"USD","value":"0.52"},"net_amount":{"currency_code":"USD","value":"0.48"}},"links":[{"href":"https://api.sandbox.paypal.com/v2/payments/captures/8R261647WV282751T","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/payments/captures/8R261647WV282751T/refund","rel":"refund","method":"POST"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"up","method":"GET"}],"create_time":"2023-12-28T19:26:28Z","update_time":"2023-12-28T19:26:28Z"}]}}],"payer":{"name":{"given_name":"test","surname":"buyer"},"email_address":"john-buyer@782media.com","payer_id":"QRVLX72Q3CVHE","address":{"country_code":"US"}},"links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"}]}
JSON, 200);
//
//        Client::$dumpResponse = true;

//        $this->initClient();
//        GenerateNewAccessToken::now($this->apiClient);
        $this->initPaypalClient("A21AAJrQt3Hn7oukhg6zJxmCKDHqMB1_TlS3f-M9tv0NSt3XpTlKsgUyRCWpBeKRyaVlFIKYcyYyr-DF4rRKg7xRfFeWY06sQ");

        $order = AuthorizeOrder::now(
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
