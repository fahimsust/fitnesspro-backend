<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductCustomsInfoRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductCustomsInfo
{
    use AsObject;

    public function handle(
        Product $product,
        ProductCustomsInfoRequest $request
    ): Product {
        $product->update(
            [
                'customs_description' => $request->customs_description,
                'tariff_number' => $request->tariff_number,
                'country_origin' => $request->country_origin,
            ]
        );
        return Product::with('details')->findOrFail($product->id);
    }
}
