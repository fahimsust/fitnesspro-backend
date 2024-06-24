<?php

namespace Domain\Products\Actions\Product;

use App\Api\Admin\Products\Requests\DistributorsInventoryRequest;
use Domain\Products\Actions\Distributors\UpdateDistributorQuantity;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateOrCreateDistributorInventory
{
    use AsObject;

    public function handle(
        Product $product,
        DistributorsInventoryRequest $request
    ) {
        $product->productDistributors()->updateOrCreate(
            [
                'distributor_id'=>$request->distributor_id,
            ],
            [
                'outofstockstatus_id' => $request->outofstockstatus_id,
                'cost' => $request->cost,
            ]
        );
        UpdateDistributorQuantity::run(
            $product,
            $request->distributor_id,
            $request->stock_qty,
        );
    }
}
