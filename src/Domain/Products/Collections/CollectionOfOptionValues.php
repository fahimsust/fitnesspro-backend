<?php

namespace Domain\Products\Collections;

use Domain\Products\Models\Product\Option\ProductOptionValue;
use Illuminate\Support\Collection;

class CollectionOfOptionValues extends Collection
{
    public function offsetGet($key): ProductOptionValue
    {
        return parent::offsetGet($key);
    }
}
