<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetOutOfStockStatusError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\Product;
use Lorisleiva\Actions\Concerns\AsObject;

class SetAvailability
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetOutOfStockStatusError::run($request);
        Product::whereIn('id', $request->ids)
            ->update(['default_outofstockstatus_id'=>$request->out_of_stock_status]);
        return CreateActivity::run(
            $request->ids,
            [
                'default_outofstockstatus_id' => $request->out_of_stock_status,
            ],
            ActionList::SET_OUT_OF_STOCK_STATUS,
        );
    }
}
