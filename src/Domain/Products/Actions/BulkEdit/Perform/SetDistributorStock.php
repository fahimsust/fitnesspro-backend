<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetSetDistributorStockError;
use Domain\Products\Actions\Distributors\BulkUpdateParentProductCombinedQuantity;
use Domain\Products\Actions\Distributors\BulkUpdateProductCombinedQuantity;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\ProductDistributor;
use Lorisleiva\Actions\Concerns\AsObject;

class SetDistributorStock
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetSetDistributorStockError::run($request);
        $currentStocks = ProductDistributor::where('distributor_id', $request->distributor_id)
            ->whereIn('product_id', $request->ids)
            ->pluck('stock_qty', 'product_id');

        ProductDistributor::where('distributor_id', $request->distributor_id)
            ->whereIn('product_id', $request->ids)
            ->update(['stock_qty' => $request->stock_qty]);

        BulkUpdateProductCombinedQuantity::run($request,$currentStocks);
        BulkUpdateParentProductCombinedQuantity::run($request,$currentStocks);

        return CreateActivity::run(
            $request->ids,
            [
                'distributor_id' => $request->distributor_id,
                'stock_qty' => $request->stock_qty,
            ],
            ActionList::MODIFY_DISTRIBUTOR_STOCK_QTY,
        );
    }
}
