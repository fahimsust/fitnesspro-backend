<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetSiteError;
use Domain\Products\Models\Product\Product;
use Domain\Products\Models\Product\ProductPricing;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByNotPublishedOnSite
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ) {
        GetSiteError::run($request);
        return DB::table(Product::Table())
            ->join(ProductPricing::Table(), Product::Table().'.id', '=', ProductPricing::Table().'.product_id')
            ->select(Product::Table().".id",Product::Table().'.title')
            ->where(ProductPricing::Table().".site_id",'=',$request->site_id)
            ->where(function ($query) {
                $query->where(Product::Table().".status","!=",1)
                    ->orWhere(ProductPricing::Table().".status","!=",1);
            })
            ->get();
    }
}
