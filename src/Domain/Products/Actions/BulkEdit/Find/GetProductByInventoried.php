<?php

namespace Domain\Products\Actions\BulkEdit\Find;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsObject;

class GetProductByInventoried
{
    use AsObject;

    public function handle(
        FindRequest $_,
    ):Collection {
        return Product::whereInventoried(1)->select('id','title')->limit(1000)->get();
    }
}
