<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductBasicsRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductBasics
{
    use AsObject;

    public function handle(
        Product $product,
        ProductBasicsRequest $request
    ): Product {
        $product->update(
            [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'url_name' => $request->url_name,
                'product_no' => $request->product_no,
                'weight' => $request->weight,
            ]
        );

        return Product::with('details')->findOrFail($product->id);
    }
}
