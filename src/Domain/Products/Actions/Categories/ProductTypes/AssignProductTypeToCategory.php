<?php

namespace Domain\Products\Actions\Categories\ProductTypes;

use App\Api\Admin\Categories\Requests\CategoryProducTypeRequest;
use Domain\Products\Models\Category\Category;
use Domain\Products\Models\Category\CategoryProductType;
use Lorisleiva\Actions\Concerns\AsObject;

class AssignProductTypeToCategory
{
    use AsObject;

    public function handle(
        Category $category,
        CategoryProducTypeRequest $request
    ): CategoryProductType {
        if (GetProductTypesAssignedToCategory::run($category, $request->type_id)) {
            throw new \Exception(__('Product type is already assigned to category'));
        }

        return $category->categoryProductTypes()->create(
            [
                'type_id' => $request->type_id,
            ]
        );
    }
}
