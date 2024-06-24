<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Spatie\LaravelData\Data;

class Payee extends Data
{
    public function __construct(
        public string $email,
        public ?string $merchantId = null,
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            email: $data['email'] ?? "",
            merchantId: $data['merchant_id'] ?? null,
        );
    }
}
