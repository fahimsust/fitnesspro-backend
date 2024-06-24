<?php

namespace Tests\Feature\Domain\Payments\Services\PaypalCheckout\Traits;

use Domain\Payments\Models\PaymentAccount;
use Domain\Payments\Services\PaypalCheckout\Client;
use Domain\Payments\Services\PaypalCheckout\DataObjects\AccessToken;
use Domain\Payments\Services\PaypalCheckout\Enums\PaypalModes;
use Illuminate\Support\Facades\Http;

trait UsesPaypalCheckoutApiClient
{
    protected Client $paypalApiClient;
    protected PaymentAccount $paymentAccount;
    protected string $payerActionUrl;

    public function initPaypalClient(?string $token = null): static
    {
        $this->paypalApiClient = new Client(
            'AVBV5X53jxLk61R6wBZvlk-LT2yF3TB9x_bgmOiVdja-PCboVZt-IG0-KEeSSTlYF4OyRk0QTnBy_B8l',
            'EGAPoiZwSMsSooaaJu-zwawD5aVgB7qggF49tMxvS4ulRkd2IpmbWrYJ68yRMvYOCfuFLoEEq9jXQQBk',
            mode: PaypalModes::Sandbox,
            accessToken: $token
        );

        return $this;
    }

    public function createAccount(?string $token = null): static
    {
        $this->paymentAccount = PaymentAccount::firstOrFactory([
            'credentials' => [
                PaypalModes::Sandbox->value => [
                    'client_id' => 'AVBV5X53jxLk61R6wBZvlk-LT2yF3TB9x_bgmOiVdja-PCboVZt-IG0-KEeSSTlYF4OyRk0QTnBy_B8l',
                    'client_secret' => 'EGAPoiZwSMsSooaaJu-zwawD5aVgB7qggF49tMxvS4ulRkd2IpmbWrYJ68yRMvYOCfuFLoEEq9jXQQBk',
                    'token' => $token
                        ? AccessToken::fromApi(
                            json_decode(<<<JSON
{
  "scope": "https://uri.paypal.com/services/invoicing https://uri.paypal.com/services/disputes/read-buyer https://uri.paypal.com/services/payments/realtimepayment https://uri.paypal.com/services/disputes/update-seller https://uri.paypal.com/services/payments/payment/authcapture openid https://uri.paypal.com/services/disputes/read-seller https://uri.paypal.com/services/payments/refund https://api-m.paypal.com/v1/vault/credit-card https://api-m.paypal.com/v1/payments/.* https://uri.paypal.com/payments/payouts https://api-m.paypal.com/v1/vault/credit-card/.* https://uri.paypal.com/services/subscriptions https://uri.paypal.com/services/applications/webhooks",
  "access_token": "{$token}",
  "token_type": "Bearer",
  "app_id": "APP-80W284485P519543T",
  "expires_in": 31668,
  "nonce": "2020-04-03T15:35:36ZaYZlGvEkV4yVSz8g6bAKFoGSEzuy3CQcz3ljhibkOHg"
}
JSON
                                , true
                            )
                        )
                        : null
                ]
            ],
            'use_test' => true
        ]);

        return $this;
    }

    protected function mockNewAccessTokenResponse(): void
    {
        Http::fakeSequence('*')
            ->push(<<<JSON
{"scope":"https://uri.paypal.com/services/customer/partner-referrals/readwrite https://uri.paypal.com/services/payments/partnerfee https://uri.paypal.com/services/invoicing https://uri.paypal.com/services/vault/payment-tokens/read https://uri.paypal.com/services/disputes/read-buyer https://uri.paypal.com/services/payments/realtimepayment https://uri.paypal.com/services/customer/onboarding/user https://api.paypal.com/v1/vault/credit-card https://api.paypal.com/v1/payments/.* https://uri.paypal.com/services/payments/referenced-payouts-items/readwrite https://uri.paypal.com/services/reporting/search/read https://uri.paypal.com/services/customer/partner https://uri.paypal.com/services/vault/payment-tokens/readwrite https://uri.paypal.com/services/customer/merchant-integrations/read https://uri.paypal.com/services/applications/webhooks https://uri.paypal.com/services/disputes/update-seller https://uri.paypal.com/services/payments/payment/authcapture openid Braintree:Vault https://uri.paypal.com/services/disputes/read-seller https://uri.paypal.com/services/payments/refund https://uri.paypal.com/services/risk/raas/transaction-context https://uri.paypal.com/services/partners/merchant-accounts/readwrite https://uri.paypal.com/services/identity/grantdelegation https://uri.paypal.com/services/customer/onboarding/account https://uri.paypal.com/payments/payouts https://uri.paypal.com/services/customer/onboarding/sessions https://api.paypal.com/v1/vault/credit-card/.* https://uri.paypal.com/services/subscriptions","access_token":"A21AAKkpWO3hOuSxww5xvfeOnx3d6ka8sop0r_2RP1KuDyFKddlvW1wJC6vZnq2MQv6rK1jWzJ0MYOno65oTa2SuG_5MARwgA","token_type":"Bearer","app_id":"APP-80W284485P519543T","expires_in":32400,"nonce":"2023-12-27T21:36:22ZPR8HFFX1_uml8srJvx8Uf_72T00_vcoV__1Kl234u3A"}
JSON
            );
    }

    protected function mockCreateOrderResponse(): void
    {
        $this->payerActionUrl = "https://www.sandbox.paypal.com/checkoutnow?token=1788572669270162R";

        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","status":"PAYER_ACTION_REQUIRED","payment_source":{"paypal":{}},"links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"},{"href":"{$this->payerActionUrl}","rel":"payer-action","method":"GET"}]}
JSON, 200);
    }

    protected function mockCaptureResponse(): void
    {
        Http::fakeSequence('*')
            ->push(<<<JSON
{"id":"1788572669270162R","status":"COMPLETED","payment_source":{"paypal":{"email_address":"john-buyer@782media.com","account_id":"QRVLX72Q3CVHE","account_status":"VERIFIED","name":{"given_name":"test","surname":"buyer"},"address":{"country_code":"US"}}},"purchase_units":[{"reference_id":"test-capture","shipping":{"name":{"full_name":"test buyer"},"address":{"address_line_1":"1 Main St","admin_area_2":"San Jose","admin_area_1":"CA","postal_code":"95131","country_code":"US"}},"payments":{"captures":[{"id":"8R261647WV282751T","status":"COMPLETED","amount":{"currency_code":"USD","value":"1.00"},"final_capture":true,"disbursement_mode":"INSTANT","seller_protection":{"status":"ELIGIBLE","dispute_categories":["ITEM_NOT_RECEIVED","UNAUTHORIZED_TRANSACTION"]},"seller_receivable_breakdown":{"gross_amount":{"currency_code":"USD","value":"1.00"},"paypal_fee":{"currency_code":"USD","value":"0.52"},"net_amount":{"currency_code":"USD","value":"0.48"}},"links":[{"href":"https://api.sandbox.paypal.com/v2/payments/captures/8R261647WV282751T","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v2/payments/captures/8R261647WV282751T/refund","rel":"refund","method":"POST"},{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"up","method":"GET"}],"create_time":"2023-12-28T19:26:28Z","update_time":"2023-12-28T19:26:28Z"}]}}],"payer":{"name":{"given_name":"test","surname":"buyer"},"email_address":"john-buyer@782media.com","payer_id":"QRVLX72Q3CVHE","address":{"country_code":"US"}},"links":[{"href":"https://api.sandbox.paypal.com/v2/checkout/orders/1788572669270162R","rel":"self","method":"GET"}]}
JSON, 200);
    }
}
