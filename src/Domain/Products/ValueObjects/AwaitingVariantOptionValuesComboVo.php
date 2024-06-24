<?php

namespace Domain\Products\ValueObjects;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class AwaitingVariantOptionValuesComboVo extends Data
{
    public function __construct(
        public array $optionValueIds,
        public Collection $productOptionValues,
    )
    {
    }
}
