<?php

namespace Domain\Products\Actions\Distributors;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class BulkUpdateProductCombinedQuantity
{
    use AsObject;

    public function handle(
        PerformRequest $request,
        Collection     $currentStocks,
    )
    {

        $differences = GetStockQtyDifferences::run($request,$currentStocks);
        foreach ($differences as $productId => $difference) {
            Product::where('id', $productId)->increment('combined_stock_qty', $difference);
        }

    }
}
