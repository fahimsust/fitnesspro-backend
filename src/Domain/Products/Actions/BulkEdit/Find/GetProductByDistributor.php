<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetDistributorError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByDistributor
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ):Collection {
        GetDistributorError::run($request);
        return Product::whereDefaultDistributorId($request->distributor_id)->select('id','title')->limit(1000)->get();
    }
}
