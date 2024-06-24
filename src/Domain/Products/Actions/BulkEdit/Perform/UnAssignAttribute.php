<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetAttributeError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Product\ProductAttribute;
use Lorisleiva\Actions\Concerns\AsObject;

class UnAssignAttribute
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetAttributeError::run($request);
        ProductAttribute::whereIn('option_id',$request->attributeList)
        ->whereIn("product_id",$request->ids)
        ->delete();
        return CreateActivity::run(
            $request->ids,
            [
                'attributeList' => $request->attributeList,
                'set' => $request->set,
            ],
            ActionList::UNASSIGN_ATTRIBUTES,
        );
    }
}
