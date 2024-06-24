<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class AccessToken extends Data
{

    public function __construct(
        public string $scope,
        public string $access_token,
        public string $token_type,
        public string $app_id,
        public int    $expires_in,
        public string $nonce,
        public Carbon $expiration,
    )
    {
    }

    public static function fromApi(array $data): static
    {
        return new self(
            scope: $data['scope'],
            access_token: $data['access_token'],
            token_type: $data['token_type'],
            app_id: $data['app_id'],
            expires_in: $data['expires_in'],
            nonce: $data['nonce'],
            expiration: isset($data['expiration'])
                ? Carbon::parse($data['expiration'])
                : Carbon::now()->addSeconds($data['expires_in']),
        );
    }

    public function isExpired(): bool
    {
        //expired or will expire within one minute
        return $this->expiration->isBefore(now()->addMinute());
    }
}
/*
 * {
  "scope": "https://uri.paypal.com/services/invoicing https://uri.paypal.com/services/disputes/read-buyer https://uri.paypal.com/services/payments/realtimepayment https://uri.paypal.com/services/disputes/update-seller https://uri.paypal.com/services/payments/payment/authcapture openid https://uri.paypal.com/services/disputes/read-seller https://uri.paypal.com/services/payments/refund https://api-m.paypal.com/v1/vault/credit-card https://api-m.paypal.com/v1/payments/.* https://uri.paypal.com/payments/payouts https://api-m.paypal.com/v1/vault/credit-card/.* https://uri.paypal.com/services/subscriptions https://uri.paypal.com/services/applications/webhooks",
  "access_token": "A21AAFEpH4PsADK7qSS7pSRsgzfENtu-Q1ysgEDVDESseMHBYXVJYE8ovjj68elIDy8nF26AwPhfXTIeWAZHSLIsQkSYz9ifg",
  "token_type": "Bearer",
  "app_id": "APP-80W284485P519543T",
  "expires_in": 31668,
  "nonce": "2020-04-03T15:35:36ZaYZlGvEkV4yVSz8g6bAKFoGSEzuy3CQcz3ljhibkOHg"
}
 */