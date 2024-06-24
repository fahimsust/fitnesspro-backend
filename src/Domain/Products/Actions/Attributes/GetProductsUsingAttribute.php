<?php

namespace Domain\Products\Actions\Attributes;

use Domain\Products\Models\Attribute\Attribute;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductsUsingAttribute
{
    use AsObject;

    public function handle(
        Attribute $attribute,
    ): Collection
    {
        return $attribute->products;
    }
}
