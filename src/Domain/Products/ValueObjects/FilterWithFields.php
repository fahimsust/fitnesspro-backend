<?php

namespace Domain\Products\ValueObjects;

use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Filters\Filter;
use Domain\Products\Models\Product\Option\ProductOption;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class FilterWithFields extends Data
{
    public function __construct(
        public Filter $filter,
        public Collection $fields
    )
    {
    }
}
