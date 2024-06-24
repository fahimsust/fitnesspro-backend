<?php

namespace Domain\Products\Actions\Distributors;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;
use Illuminate\Support\Collection;

class BulkUpdateParentProductCombinedQuantity
{
    use AsObject;

    public function handle(
        PerformRequest $request,
        Collection     $currentStocks,
    )
    {
        $childUpdates = GetStockQtyDifferences::run($request,$currentStocks);
        if (!empty($childUpdates)) {
            $parentChildMap = [];
            $products = Product::whereIn('id', array_keys($childUpdates))
                          ->select('id', 'parent_product')
                          ->get();

            foreach ($products as $product) {
                $parentId = $product->parent_product;
                $childId = $product->id;

                if (isset($childUpdates[$childId])) {
                    if (!isset($parentChildMap[$parentId])) {
                        $parentChildMap[$parentId] = 0;
                    }
                    $parentChildMap[$parentId] += $childUpdates[$childId];
                }
            }

            foreach ($parentChildMap as $parentId => $totalDifference) {
                if ($totalDifference != 0) {
                    Product::where('id', $parentId)->increment('combined_stock_qty', $totalDifference);
                }
            }
        }
    }
}
