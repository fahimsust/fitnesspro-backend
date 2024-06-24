<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductDetailsRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductContent
{
    use AsObject;

    public function handle(
        Product $product,
        ProductDetailsRequest $request
    ): Product {
        ProductDetail::updateOrCreate(
            [
                'product_id'=>$product->id,
            ],
            [
                'summary' => $request->summary,
                'description' => $request->description
            ]
        );

        return Product::with('details')->findOrFail($product->id);
    }
}
