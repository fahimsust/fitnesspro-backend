<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetBrandError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateBrand
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetBrandError::run($request);
        ProductDetail::whereIn('product_id',$request->ids)->update(['brand_id'=>$request->brand_id]);
        return CreateActivity::run(
            $request->ids,
            [
                'brand_id' => $request->brand_id,
            ],
            ActionList::ASSIGN_BRAND,
        );
    }
}
