<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\AccessoryField\AccessoryField;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessoryField;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductAccessoryField
{
    use AsObject;

    public function handle(
        Product $product,
        AccessoryField $accessoryField,
    ): ProductAccessoryField {
        return $product->productAccessoryFields()->whereAccessoriesFieldsId($accessoryField->id)->firstOrFail();
    }
}
