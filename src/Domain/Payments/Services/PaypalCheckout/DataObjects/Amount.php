<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Spatie\LaravelData\Data;

class Amount extends Data
{
    public function __construct(
        public string $currencyCode,
        public string $value,
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            currencyCode: $data['currency_code'],
            value: $data['value'],
        );
    }
}

/*
    {
        "currency_code": "USD",
        "value": "100.00"
    }
 */
