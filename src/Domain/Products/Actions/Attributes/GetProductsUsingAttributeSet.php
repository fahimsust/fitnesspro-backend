<?php

namespace Domain\Products\Actions\Attributes;

use Domain\Products\Models\Attribute\AttributeSet;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductsUsingAttributeSet
{
    use AsObject;

    public function handle(
        AttributeSet $attributeSet,
    ): Collection {
        return $attributeSet->products;
    }
}
