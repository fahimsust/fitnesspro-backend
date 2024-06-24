<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductMetaDataRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductMetaData
{
    use AsObject;

    public function handle(
        Product $product,
        ProductMetaDataRequest $request
    ): Product {
        $product->update(
            [
                'meta_title' => $request->meta_title,
                'meta_desc' => $request->meta_desc,
                'meta_keywords' => $request->meta_keywords,
            ]
        );
        return Product::with('details')->findOrFail($product->id);
    }
}
