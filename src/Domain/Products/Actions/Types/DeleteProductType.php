<?php

namespace Domain\Products\Actions\Types;

use Domain\Products\Models\Product\ProductDetail;
use Domain\Products\Models\Product\ProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteProductType
{
    use AsObject;

    public function handle(
        ProductType $productType,
    ) {
        if (ProductDetail::whereTypeId($productType->id)->count() > 0) {
            throw new \Exception(__('You have to update the product type of :products to delete this type', [
                'products' => $productType->products()
                    ->select('title')
                    ->take(5)
                    ->pluck('title')
                    ->implode(', '),
            ]));
        }

        $productType->delete();
    }
}
