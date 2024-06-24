<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryMetaDataRequest;
use Domain\Products\Actions\Categories\UpdateCategoryMetaData;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryMetaDataController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category,
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryMetaDataRequest $request)
    {
        return response(
            UpdateCategoryMetaData::run($category, $request),
            Response::HTTP_CREATED
        );
    }
}
