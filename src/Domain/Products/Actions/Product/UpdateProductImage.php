<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\UpdateProductImageRequest;
use Domain\Products\Models\Product\ProductImage;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductImage
{
    use AsObject;

    public function handle(
        ProductImage $productImage,
        UpdateProductImageRequest $request
    ): ProductImage {
        $productImage->update(
            [
                'caption' => $request->caption,
                'rank' => $request->rank,
                'show_in_gallery' => $request->show_in_gallery,
            ]
        );

        return $productImage;
    }
}
