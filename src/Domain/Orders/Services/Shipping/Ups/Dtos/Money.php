<?php

namespace Domain\Orders\Services\Shipping\Ups\Dtos;

use Spatie\LaravelData\Data;

class Money extends Data
{
    public function __construct(
        public string $currencyCode,
        public string $amount,
    )
    {
    }

    public static function fromApi(?array $data): ?self
    {
        if (!$data) {
            return null;
        }

        return new self(
            currencyCode: $data['CurrencyCode'],
            amount: $data['MonetaryValue'],
        );
    }
}
