<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\ProductAddToCartSettingsRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductAddToCartSettings
{
    use AsObject;

    public function handle(
        Product $product,
        ProductAddToCartSettingsRequest $request
    ): Product {
        $product->update(
            [
                'addtocart_external_label' => $request->addtocart_external_label,
                'addtocart_external_link' => $request->addtocart_external_link,
                'addtocart_setting' => $request->addtocart_setting,
            ]
        );
        return Product::with('details')->findOrFail($product->id);
    }
}
