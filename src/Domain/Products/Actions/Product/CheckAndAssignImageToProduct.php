<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class CheckAndAssignImageToProduct
{
    use AsObject;

    public function handle(
        Product $product,
        int $imageId,
    ): void {
        if ($product->productImages()->whereImageId($imageId)->exists()) {
            return;
        }

        $product->productImages()->create(['image_id' => $imageId]);
    }
}
