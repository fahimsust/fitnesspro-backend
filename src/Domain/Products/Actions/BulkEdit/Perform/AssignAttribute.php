<?php

namespace Domain\Products\Actions\BulkEdit\Perform;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Actions\BulkEdit\CreateActivity;
use Domain\Products\Actions\BulkEdit\Perform\Error\GetAttributeError;
use Domain\Products\Enums\BulkEdit\ActionList;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Product\ProductAttribute;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignAttribute
{
    use AsObject;

    public function handle(
        PerformRequest $request,
    ): int {
        GetAttributeError::run($request);
        $attributeOptions = AttributeSet::find($request->set)->options->pluck('id')->toArray();
        ProductAttribute::whereIn('option_id',$attributeOptions)->delete();
        foreach ($request->ids as $product_id) {
            foreach($request->attributeList as $value)
            {
                ProductAttribute::create([
                    'option_id' => $value,
                    'product_id' => $product_id
                ]);
            }
        }
        return CreateActivity::run(
            $request->ids,
            [
                'attributeList' => $request->attributeList,
                'set' => $request->set,
            ],
            ActionList::ASSIGN_ATTRIBUTES,
        );
    }
}
