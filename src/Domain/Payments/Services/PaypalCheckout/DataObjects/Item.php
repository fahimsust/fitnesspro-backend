<?php

namespace Domain\Payments\Services\PaypalCheckout\DataObjects;

use Domain\Payments\Services\PaypalCheckout\Enums\ItemCategory;
use Spatie\LaravelData\Data;

class Item extends Data
{
    public function __construct(
        public string        $name,
        public int           $quantity,
        public ?string       $description = null,
        public ?string       $sku = null,
        public ?ItemCategory $category = null,
        public ?Amount       $unitAmount = null,
        public ?Amount       $tax = null,
    )
    {
    }

    public static function fromApi(array $data): static
    {
        return new self(
            name: $data['name'],
            quantity: $data['quantity'],
            description: $data['description'] ?? null,
            sku: $data['sku'] ?? null,
            category: $data['category'] ?? null,
            unitAmount: Amount::fromApi($data['unit_amount']),
            tax: Amount::fromApi($data['tax']) ?? null,
        );
    }
}

/*
    {
      "reference_id": "d9f80740-38f0-11e8-b467-0ed5f89f718b",
      "amount": {
        "currency_code": "USD",
        "value": "100.00"
      }
    }
 */
