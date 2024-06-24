<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryProducTypeRequest;
use Domain\Products\Actions\Categories\ProductTypes\AssignProductTypeToCategory;
use Domain\Products\Actions\Categories\ProductTypes\RemoveProductTypeFromCategory;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryProductTypesController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category->filteringProductTypes,
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryProducTypeRequest $request)
    {
        return response(
            AssignProductTypeToCategory::run($category, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Category $category, int $typeId)
    {
        return response(
            RemoveProductTypeFromCategory::run($category, $typeId),
            Response::HTTP_OK
        );
    }
}
