<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class SetInventoried
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        Product::whereIn('id', $request->ids)
            ->update(['inventoried'=>1]);
        return CreateActivity::run(
            $request->ids,
            [
                'inventoried' => 1,
            ],
            ActionList::SET_INVENTORIED,
        );
    }
}
