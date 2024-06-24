<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Actions\BulkEdit\Find\Error\GetStatusError;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByNotInventoried
{
    use AsObject;

    public function handle(
        FindRequest $_,
    ):Collection {
        return Product::whereInventoried(0)->select('id','title')->limit(1000)->get();
    }
}
