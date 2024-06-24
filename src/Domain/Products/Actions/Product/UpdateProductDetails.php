<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\UpdateProductDetailsRequest;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductDetails
{
    use AsObject;

    public function handle(
        Product $product,
        UpdateProductDetailsRequest $request
    ): Product {
        $product->details()->update(
            [
                'brand_id' => $request->brand_id,
                'downloadable' => $request->downloadable,
                'downloadable_file' => $request->downloadable_file,
                'default_category_id' => $request->default_category_id,
                'create_children_auto' => $request->create_children_auto,
                'display_children_grid' => $request->display_children_grid,
                'override_parent_description' => $request->override_parent_description,
                'allow_pricing_discount' => $request->allow_pricing_discount,
            ]
        );

        return Product::with('details')->findOrFail($product->id);
    }
}
