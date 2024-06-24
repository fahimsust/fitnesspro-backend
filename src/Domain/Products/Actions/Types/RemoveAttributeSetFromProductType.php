<?php

namespace Domain\Products\Actions\Types;

use Domain\Products\Models\Product\ProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class RemoveAttributeSetFromProductType
{
    use AsObject;

    public function handle(
        ProductType $productType,
        int $set_id,
    ) {
        if (! IsAttributeSetAssignedToProductType::run($productType, $set_id)) {
            throw new \Exception(__('Attribute Set not assigned to product type'));
        }

        $productType->productTypeAttributeSets()->whereSetId($set_id)->delete();
    }
}
