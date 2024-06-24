<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetSiteError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByPublishedOnSite
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        $products = [];
        GetSiteError::run($request);
        $productPricings = ProductPricing::where('site_id',$request->site_id)
        ->where('status',1)
        ->groupBy('product_id')
        ->limit(1000)
        ->get();
        if($productPricings)
        {
            $products = Product::whereIn('id',$productPricings->pluck('product_id')->toArray())
            ->where('status',1)
            ->limit(1000)
            ->get();
        }

        return $products;
    }
}
