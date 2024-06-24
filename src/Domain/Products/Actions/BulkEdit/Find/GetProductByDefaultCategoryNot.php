<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetCategoryError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByDefaultCategoryNot
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetCategoryError::run($request);
        $productDetails = ProductDetail::where('default_category_id', $request->category_id)
            ->groupBy('product_id')
            ->limit(1000)
            ->get();
        if ($productDetails) {
            $products = Product::whereNotIn('id', $productDetails->pluck('product_id')->toArray())->limit(1000)->get();
        }
        else
        {
            $products = Product::all();
        }
        return $products;
    }
}
