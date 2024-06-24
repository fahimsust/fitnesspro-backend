<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Spatie\LaravelData\Data;

class Name extends Data
{
    public function __construct(
        public string $givenName,
        public string $surname,
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            givenName: $data['given_name'],
            surname: $data['surname'],
        );
    }
}
