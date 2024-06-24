<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetProductTypeError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateProductType
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetProductTypeError::run($request);
        ProductDetail::whereIn('product_id',$request->ids)->update(['type_id'=>$request->product_type_id]);
        return CreateActivity::run(
            $request->ids,
            [
                'type_id' => $request->product_type_id,
            ],
            ActionList::ASSIGN_PRODUCT_TYPE,
        );
    }
}
