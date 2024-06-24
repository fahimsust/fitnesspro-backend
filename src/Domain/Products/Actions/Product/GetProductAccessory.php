<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductAccessory
{
    use AsObject;

    public function handle(
        Product $product,
        Product $accessory,
    ): ProductAccessory {
        return $product->productAccessories()->whereAccessoryId($accessory->id)->firstOrFail();
    }
}
