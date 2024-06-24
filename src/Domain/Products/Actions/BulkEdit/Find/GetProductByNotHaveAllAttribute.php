<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetAttributeError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductAttribute;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByNotHaveAllAttribute
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetAttributeError::run($request);
        $productAttributes = ProductAttribute::whereIn('option_id',$request->attributeList)
        ->select(DB::raw('count(option_id) as total,product_id'))
        ->groupBy('product_id')
        ->havingRaw('count(option_id) != ?', [count($request->attributeList)])
        ->limit(1000)
        ->get();
        if($productAttributes)
        {
            $products = Product::whereIn('id',$productAttributes->pluck('product_id')->toArray())->limit(1000)->get();
        }
        return $products;
    }
}
