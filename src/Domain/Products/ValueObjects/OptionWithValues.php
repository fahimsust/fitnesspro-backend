<?php

namespace Domain\Products\ValueObjects;

use Domain\Products\Collections\CollectionOfOptionValues;
use Domain\Products\Models\Product\Option\ProductOption;
use Spatie\LaravelData\Data;

class OptionWithValues extends Data
{
    public function __construct(
        public ProductOption $option,
        public CollectionOfOptionValues $values,
    )
    {
    }
}
