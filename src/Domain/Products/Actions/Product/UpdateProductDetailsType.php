<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\UpdateProductDetailsTypeRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductDetailsType
{
    use AsObject;

    public function handle(
        Product $product,
        UpdateProductDetailsTypeRequest $request
    ): Product {
        if($product->details->type_id != $request->type_id)
        {
            $product->productAttributes()->delete();
        }
        $product->details()->update(
            [
                'type_id' => $request->type_id,
            ]
        );

        return Product::with('details')->findOrFail($product->id);
    }
}
