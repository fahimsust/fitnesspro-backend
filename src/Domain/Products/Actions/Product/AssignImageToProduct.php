<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductImageRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductImage;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignImageToProduct
{
    use AsObject;

    public function handle(
        Product $product,
        ProductImageRequest $request,
    ): ProductImage {
        return $product->productImages()->create(
            [
                'image_id' => $request->image_id,
                'caption' => $request->caption,
                'rank' => $request->rank,
                'show_in_gallery' => $request->show_in_gallery,
            ]
        );
    }
}
