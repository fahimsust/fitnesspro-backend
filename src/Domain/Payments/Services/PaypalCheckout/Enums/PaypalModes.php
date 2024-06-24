<?php

namespace Domain\Payments\Services\PaypalCheckout\Enums;

enum PaypalModes: string
{
    case Live = 'live';
    case Sandbox = 'sandbox';

    public function url(): string
    {
        return match ($this) {
            self::Live => 'https://api-m.paypal.com/',
            self::Sandbox => 'https://api-m.sandbox.paypal.com/',
        };
    }
}
