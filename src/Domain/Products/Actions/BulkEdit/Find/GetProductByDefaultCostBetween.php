<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetDefaultCostError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByDefaultCostBetween
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ):Collection {
        GetDefaultCostError::run($request);
        return Product::whereBetween('default_cost', [$request->min, $request->max])->select('id','title')->limit(1000)->get();
    }
}
