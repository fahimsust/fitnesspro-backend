<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetStatusError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByStatus
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ):Collection {
        GetStatusError::run($request);
        return Product::whereStatus($request->status)->select('id','title')->limit(1000)->get();
    }
}
