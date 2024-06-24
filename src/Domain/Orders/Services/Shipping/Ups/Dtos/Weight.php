<?php

namespace Domain\Orders\Services\Shipping\Ups\Dtos;

use Spatie\LaravelData\Data;

class Weight extends Data
{
    public function __construct(
        public CodeWithDescription $uom,
        public string              $value,
    )
    {
    }

    public static function fromApi(?array $data): ?self
    {
        if (!$data) {
            return null;
        }

        return new self(
            uom: CodeWithDescription::fromApi($data['UnitOfMeasurement']),
            value: $data['Weight'],
        );
    }
}
