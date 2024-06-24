<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetCategoryError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\ProductDetail;
use Lorisleiva\Actions\Concerns\AsObject;

class UpdateDefaultCategory
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetCategoryError::run($request);
        ProductDetail::whereIn('product_id',$request->ids)->update(['default_category_id'=>$request->category_id]);
        return CreateActivity::run(
            $request->ids,
            [
                'default_category_id' => $request->category_id,
            ],
            ActionList::ASSIGN_DEFAULT_CATEGORY,
        );
    }
}
