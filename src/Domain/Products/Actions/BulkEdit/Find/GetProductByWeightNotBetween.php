<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetWeightError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByWeightNotBetween
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ):Collection {
        GetWeightError::run($request);
        return Product::whereNotBetween('weight', [$request->min, $request->max])->select('id','title')->limit(1000)->get();
    }
}
