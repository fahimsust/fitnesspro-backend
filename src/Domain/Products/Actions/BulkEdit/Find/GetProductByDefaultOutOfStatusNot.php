<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetDefaultOutOfStatusError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByDefaultOutOfStatusNot
{
    use AsObject;

    public function handle(
        FindRequest $request,
    ):Collection {
        GetDefaultOutOfStatusError::run($request);
        return Product::where('default_outofstockstatus_id','<>',$request->out_of_stock_status)->select('id','title')->limit(1000)->get();
    }
}
