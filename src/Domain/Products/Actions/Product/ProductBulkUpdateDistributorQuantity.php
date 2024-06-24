<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\BulkProductDistributorStockQuantityRequest;
use Domain\Products\Actions\Distributors\UpdateDistributorQuantity;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class ProductBulkUpdateDistributorQuantity
{
    use AsObject;

    public function handle(
        BulkProductDistributorStockQuantityRequest $request,
    ) {
        Product::whereIn('id', $request->products)->get()->each(
            fn (Product $product) => UpdateDistributorQuantity::run(
                $product,
                $request->distributor_id,
                $request->stock_qty,
            )
        );
    }
}
