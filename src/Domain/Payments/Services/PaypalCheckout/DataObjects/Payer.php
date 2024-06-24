<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;

class Payer extends Data
{
    public function __construct(
        public string  $email,
        public string  $payerId,
        public Name    $name,
        public array   $phone,
        public ?Carbon $birthDate,
        public array   $taxInfo,
        public array   $address,
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            email: $data['email_address'],
            payerId: $data['payer_id'],
            name: Name::fromApi($data['name']),
            phone: $data['phone'] ?? [],
            birthDate: isset($data['birth_date'])
                ? Carbon::parse($data['birth_date'])
                : null,
            taxInfo: $data['tax_info'] ?? [],
            address: $data['address'] ?? [],
        );
    }
}
