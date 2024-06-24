<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductImage
{
    use AsObject;

    public function handle(
        Product $product,
        int $image_id,
    ): ProductImage {
        return $product->productImages()->whereImageId($image_id)->firstOrFail();
    }
}
