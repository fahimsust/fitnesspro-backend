<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Spatie\LaravelData\Data;

class PurchaseUnit extends Data
{
    public function __construct(
        public string  $referenceId,
        public ?Amount $amount,
        public ?string $description = null,
        public ?string $customId = null,
        public ?string $invoiceId = null,
        public ?string $id = null,
        public ?string $softDescriptor = null,
        public ?array  $items = null,
        public ?Payee  $payee = null,
    )
    {
    }

    public static function fromApi(array $data): self
    {
        return new self(
            referenceId: $data['reference_id'],
            amount: isset($data['amount'])
                ? Amount::fromApi($data['amount'])
                : null,
            description: $data['description'] ?? null,
            customId: $data['custom_id'] ?? null,
            invoiceId: $data['invoice_id'] ?? null,
            id: $data['id'] ?? null,
            softDescriptor: $data['soft_descriptor'] ?? null,
            items: $data['items'] ?? null,
            payee: Payee::fromApi($data['payee'] ?? []),
        );
    }
}
