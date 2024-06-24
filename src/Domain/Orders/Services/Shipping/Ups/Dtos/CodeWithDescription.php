<?php

namespace Domain\Orders\Services\Shipping\Ups\Dtos;

use Spatie\LaravelData\Data;

class CodeWithDescription extends Data
{
    public function __construct(
        public string $code,
        public string $description,
    )
    {
    }

    public static function fromApi(?array $data): ?self
    {
        if (!$data) {
            return null;
        }

        return new self(
            code: $data['Code'],
            description: $data['Description'],
        );
    }
}

/*
 * {
        "Code": "s",
        "Description": "string"

}
 */
