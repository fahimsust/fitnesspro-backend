<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\CreateProductRequest;
use Domain\Products\Actions\pricing\CreateProductPricing;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateProduct
{
    use AsObject;

    public function handle(
        CreateProductRequest $request
    ): Product {
        $product = Product::create(
            [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'url_name' => $request->url_name,
                'product_no' => $request->product_no,
                'weight' => $request->weight,
                'default_distributor_id' => $request->default_distributor_id,
            ]
        );

        $product->settings()->create();

        CreateProductDetails::run($product, $request);
        CreateProductPricing::run($product, $request);

        return Product::with('details')->findOrFail($product->id);
    }
}
