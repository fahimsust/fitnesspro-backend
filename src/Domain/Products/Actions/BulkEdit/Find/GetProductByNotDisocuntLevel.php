<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Products\Actions\BulkEdit\Find\Error\GetDiscountLevelError;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByNotDisocuntLevel
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetDiscountLevelError::run($request);
        $productDisocuntLevel = DiscountLevelProduct::where('discount_level_id',$request->discount_level_id)
        ->groupBy('product_id')
        ->limit(1000)
        ->get();
        if($productDisocuntLevel)
        {
            $products = Product::whereNotIn('id',$productDisocuntLevel->pluck('product_id')->toArray())
            ->limit(1000)
            ->get();
        }

        return $products;
    }
}
