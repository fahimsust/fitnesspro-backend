<?php

namespace Domain\Payments\Services\PaypalCheckout\Enpoints;

use Domain\Payments\Services\PaypalCheckout\Contracts\PaypalEndpoint;

class Orders implements PaypalEndpoint
{
    public static function baseUri(): string
    {
        return '/v2/checkout/orders/';
    }

    public function get(string $orderId): string
    {
        return self::baseUri() . $orderId;
    }

    public function authorize(string $orderId): string
    {
        return $this->get($orderId) . '/authorize';
    }

    public function capture(string $orderId): string
    {
        return $this->get($orderId) . '/capture';
    }
}
