<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\CreateProductRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateProductDetails
{
    use AsObject;

    public function handle(
        Product $product,
        CreateProductRequest $request
    ): ProductDetail {
        return $product->details()->create(
            [
                'summary' => $request->summary,
                'description' => $request->description,
                'product_attributes' => $request->product_attributes,
            ]
        );
    }
}
