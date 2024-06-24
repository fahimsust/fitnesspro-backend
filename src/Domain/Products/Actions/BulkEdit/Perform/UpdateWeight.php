<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetWeightError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateWeight
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int
    {
        GetWeightError::run($request);

        Product::whereIn('id', $request->ids)
            ->update(['weight' => $request->weight]);

        return CreateActivity::run(
            $request->ids,
            [
                'weight' => $request->weight,
            ],
            ActionList::SET_WEIGHT,
        );
    }
}
