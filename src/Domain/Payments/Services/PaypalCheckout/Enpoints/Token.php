<?php

namespace Domain\Payments\Services\PaypalCheckout\Enpoints;

use Domain\Payments\Services\PaypalCheckout\Contracts\PaypalEndpoint;

class Token implements PaypalEndpoint
{
    public static function baseUri(): string
    {
        return '/v1/oauth2/token/';
    }
}
