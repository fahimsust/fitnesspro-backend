<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAccessory;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductAttribute
{
    use AsObject;

    public function handle(
        Product $product,
        int $option_id,
    ): ProductAccessory {
        return $product->productAttributes()->whereOptionId($option_id)->firstOrFail();
    }
}
