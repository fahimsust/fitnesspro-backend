<?php

namespace Domain\Orders\Dtos;

use Spatie\LaravelData\Data;

class OptionCustomValuesData extends Data
{
    public function __construct(
        public int $optionValueId,
        public string|array|null $customValue = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'option_value_id' => $this->optionValueId,
            'custom_value' => $this->customValue,
        ];
    }
}
