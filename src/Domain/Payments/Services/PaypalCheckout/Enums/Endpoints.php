<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

use Domain\Payments\Services\PaypalCheckout\Contracts\PaypalEndpoint;
use Domain\Payments\Services\PaypalCheckout\Enpoints\Orders;
use Domain\Payments\Services\PaypalCheckout\Enpoints\Token;

enum Endpoints: string
{
    case Orders = Orders::class;
    case Token = Token::class;

    public function resolve(): PaypalEndpoint
    {
        return resolve($this->value);
    }

    public function baseUri(): string
    {
        return $this->resolve()->baseUri();
    }
}
