<?php

namespace Domain\Products\Actions\Distributors;

use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDistributor;
use Lorisleiva\Actions\Concerns\AsObject;
use Symfony\Component\HttpFoundation\Response;

class UpdateDistributorQuantity
{
    use AsObject;

    public function handle(
        Product $product,
        int     $distributor_id,
        int     $stock_qty,
    )
    {
        $productDistributor = ProductDistributor::where('product_id', $product->id)
            ->where('distributor_id', $distributor_id)
            ->first();

        if (!$productDistributor) {
            throw new \Exception(
                __(
                    "Can't update stock: product distributor not found."
                ),
                Response::HTTP_CONFLICT
            );
        }

        $stockQuantityDif = $stock_qty - $productDistributor->stock_qty;
        $productDistributor->stock_qty = $stock_qty;
        $productDistributor->save();

        UpdateProductCombinedQuantity::run($product, $stockQuantityDif);
        UpdateParentProductCombinedQuantity::run($product, $stockQuantityDif);

        return $product;
    }
}
