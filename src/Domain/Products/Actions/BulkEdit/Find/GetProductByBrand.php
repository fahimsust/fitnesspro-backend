<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetBrandError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByBrand
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetBrandError::run($request);
        $productDetails = ProductDetail::where('brand_id', $request->brand_id)
            ->groupBy('product_id')
            ->limit(1000)
            ->get();
        if ($productDetails) {
            $products = Product::whereIn('id', $productDetails->pluck('product_id')->toArray())->limit(1000)->get();
        }

        return $products;
    }
}
