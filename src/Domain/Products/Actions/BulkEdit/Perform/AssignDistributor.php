<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetDistributorError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignDistributor
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetDistributorError::run($request);
        Product::whereIn('id', $request->ids)
            ->update(['default_distributor_id'=>$request->distributor_id]);
        return CreateActivity::run(
            $request->ids,
            [
                'default_distributor_id' => $request->distributor_id,
            ],
            ActionList::ASSIGN_DISTRIBUTOR,
        );
    }
}
