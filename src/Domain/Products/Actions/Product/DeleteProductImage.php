<?php

namespace Domain\Products\Actions\Product;

use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;
use Symfony\Component\HttpFoundation\Response;

class DeleteProductImage
{
    use AsObject;

    public function handle(
        Product $product,
        int $image_id,
    ) {
        if($image_id == $product->details_img_id)
        {
            throw new \Exception(
                __(
                    "Can't delete: product image is set to product details image."
                )
            );
        }
        if($image_id == $product->category_img_id)
        {
            throw new \Exception(
                __(
                    "Can't delete: product image is set to product category image."
                )
            );
        }

        return GetProductImage::run($product, $image_id)->delete();
    }
}
