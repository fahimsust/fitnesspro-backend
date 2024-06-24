<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetCombinedStockError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByCombinedStockNotBetween
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ):Collection {
        GetCombinedStockError::run($request);
        return Product::whereNotBetween('combined_stock_qty', [$request->min, $request->max])->select('id','title')->limit(1000)->get();
    }
}
