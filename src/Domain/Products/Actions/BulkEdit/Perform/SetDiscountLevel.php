<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Discounts\Models\Level\DiscountLevelProduct;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetDiscountLevelError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Lorisleiva\Actions\Concerns\AsObject;

class SetDiscountLevel
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetDiscountLevelError::run($request);
        DiscountLevelProduct::whereIn('product_id',$request->ids)->update(['discount_level_id'=>$request->discount_level_id]);
        return CreateActivity::run(
            $request->ids,
            [
                'discount_level_id' => $request->discount_level_id,
            ],
            ActionList::ASSIGN_TO_DISCOUNT_LEVEL,
        );
    }
}
