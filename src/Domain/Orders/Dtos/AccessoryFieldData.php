<?php

namespace Domain\Orders\Dtos;

use Spatie\LaravelData\Data;

class AccessoryFieldData extends Data
{
    public function __construct(
        public int $fieldId,
        public int $productId,
        public int $qty,
        public array $options = [],
    ) {
    }

    public function toArray(): array
    {
        return [
        ];
    }
}
