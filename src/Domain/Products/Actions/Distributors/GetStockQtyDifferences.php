<?php

namespace Domain\Products\Actions\Distributors;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Collection;

class GetStockQtyDifferences
{
    use AsObject;

    public function handle(
        PerformRequest $request,
        Collection     $currentStocks,
    )
    {
        $differences = [];
        foreach ($currentStocks as $productId => $oldStockQty) {
            $difference = $request->stock_qty - $oldStockQty;
            $differences[$productId] = $difference;
        }
        return $differences;

    }
}
