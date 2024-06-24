<?php

namespace Domain\Products\Actions\Types;

use Domain\Products\Models\Product\ProductType;
use Domain\Products\Models\Product\ProductTypeAttributeSet;
use Lorisleiva\Actions\Concerns\AsObject;

class IsAttributeSetAssignedToProductType
{
    use AsObject;

    public function handle(
        ProductType $productType,
        int $set_id,
    ): ?ProductTypeAttributeSet {
        return $productType->productTypeAttributeSets()->whereSetId($set_id)->first();
    }
}
