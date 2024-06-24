<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetAttributeError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByNotHaveAnyAttribute
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetAttributeError::run($request);
        $productAttributes = ProductAttribute::whereIn('option_id',$request->attributeList)
        ->groupBy('product_id')
        ->limit(1000)
        ->get();
        if($productAttributes)
        {
            $products = Product::whereNotIn('id',$productAttributes->pluck('product_id')->toArray())->limit(1000)->get();
        }
        return $products;
    }
}
