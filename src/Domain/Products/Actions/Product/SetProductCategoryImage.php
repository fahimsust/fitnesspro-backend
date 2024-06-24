<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductCategoryImageRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class SetProductCategoryImage
{
    use AsObject;

    public function handle(
        Product $product,
        ProductCategoryImageRequest $request
    ): Product {
        CheckAndAssignImageToProduct::run($product, $request->category_img_id);

        $product->update([
            'category_img_id' => $request->category_img_id,
        ]);

        return Product::with('details')->findOrFail($product->id);
    }
}
