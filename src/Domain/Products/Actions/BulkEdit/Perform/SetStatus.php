<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetStatusError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class SetStatus
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetStatusError::run($request);
        Product::whereIn('id', $request->ids)
            ->update(['status'=>$request->status]);
        return CreateActivity::run(
            $request->ids,
            [
                'status' => $request->status,
            ],
            ActionList::SET_STATUS,
        );
    }
}
