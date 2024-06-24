<?php

namespace Domain\Products\Collections;

use Domain\Products\ValueObjects\OptionWithValues;
use Illuminate\Support\Collection;

class CollectionOfOptionsWithValues extends Collection
{
    public function offsetGet($key): OptionWithValues
    {
        return parent::offsetGet($key);
    }
}
