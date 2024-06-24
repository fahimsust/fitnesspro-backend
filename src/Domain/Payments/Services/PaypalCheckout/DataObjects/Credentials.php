<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class Credentials extends Data
{

    public function __construct(
        public string $client_id,
        public string $client_secret,
        public AccessToken $token
    )
    {
    }

    public static function fromDb(array $data): static
    {
        return new self(
            client_id: $data['client_id'],
            client_secret: $data['client_secret'],
            token: AccessToken::fromApi($data['token'])
        );
    }
}
