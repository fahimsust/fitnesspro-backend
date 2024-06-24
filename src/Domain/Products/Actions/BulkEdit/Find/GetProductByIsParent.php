<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetStatusError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByIsParent
{
    use AsObject;

    public function handle(
        FindRequest $_,
    ):Collection {
        return Product::whereNull('parent_product')->select('id','title')->limit(1000)->get();
    }
}
