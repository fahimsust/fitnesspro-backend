<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductRelated;
use Lorisleiva\Actions\Concerns\AsObject;

class GetRelatedProduct
{
    use AsObject;

    public function handle(
        Product $product,
        Product $related,
    ): ProductRelated {
        return $product->productRelated()->whereRelatedId($related->id)->firstOrFail();
    }
}
