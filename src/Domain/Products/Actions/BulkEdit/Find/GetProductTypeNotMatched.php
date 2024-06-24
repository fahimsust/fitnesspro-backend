<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetProductTypeError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductTypeNotMatched
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetProductTypeError::run($request);
        $productDetails = ProductDetail::where('type_id',$request->product_type_id)->limit(1000)->get();
        if($productDetails)
        {
            $products = Product::whereNotIn('id',$productDetails->pluck('product_id')->toArray())->limit(1000)->get();
        }

        return $products;
    }
}
