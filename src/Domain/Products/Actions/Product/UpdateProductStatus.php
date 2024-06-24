<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductStatusRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductStatus
{
    use AsObject;

    public function handle(
        Product $product,
        ProductStatusRequest $request
    ): Product {
        $product->update(
            [
                'status' => $request->status,
            ]
        );
        return Product::with('details')->findOrFail($product->id);
    }
}
