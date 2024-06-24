<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetParentError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByParentId
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ):Collection {
        GetParentError::run($request);
        return Product::whereParentProduct($request->value)->select('id','title')->limit(1000)->get();
    }
}
