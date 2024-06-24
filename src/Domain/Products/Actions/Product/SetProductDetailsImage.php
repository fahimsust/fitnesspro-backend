<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductDetailsImageRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class SetProductDetailsImage
{
    use AsObject;

    public function handle(
        Product $product,
        ProductDetailsImageRequest $request
    ): Product {
        CheckAndAssignImageToProduct::run($product, $request->details_img_id);

        $product->update([
            'details_img_id' => $request->details_img_id,
        ]);

        return Product::with('details')->findOrFail($product->id);
    }
}
