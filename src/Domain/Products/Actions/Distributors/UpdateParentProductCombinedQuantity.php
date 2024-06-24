<?php

namespace Domain\Products\Actions\Distributors;

use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateParentProductCombinedQuantity
{
    use AsObject;

    public function handle(
        Product $product,
        int     $combined_stock_qty,
    )
    {
        if (!$product->parent_product) {
            return $product;
        }


        $parent = Product::findOrFail($product->parent_product);
        $parent->combined_stock_qty = $parent->combined_stock_qty + $combined_stock_qty;
        $parent->save();

        return $product;
    }
}
