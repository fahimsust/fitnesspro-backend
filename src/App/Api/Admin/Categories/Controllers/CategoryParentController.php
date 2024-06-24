<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryParentRequest;
use App\Api\Admin\Categories\Requests\CategoryParentSearchRequest;
use Domain\Products\Actions\Categories\UpdateCategoryParent;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryParentController extends AbstractController
{
    public function index(CategoryParentSearchRequest $request)
    {
        return response(
            Category::query()
                ->availableToAssignAsParent($request)
                ->get(),
            Response::HTTP_OK
        );
    }

    public function update(Category $category, CategoryParentRequest $request)
    {
        return response(
            UpdateCategoryParent::run($category, $request->parent_id),
            Response::HTTP_CREATED
        );
    }
}
