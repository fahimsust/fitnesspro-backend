<?php

namespace Domain\Products\Actions\Distributors;

use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductCombinedQuantity
{
    use AsObject;

    public function handle(
        Product $product,
        int     $combined_stock_qty,
    )
    {
        $product->combined_stock_qty = $product->combined_stock_qty + $combined_stock_qty;
        $product->save();

        return $product;
    }
}
