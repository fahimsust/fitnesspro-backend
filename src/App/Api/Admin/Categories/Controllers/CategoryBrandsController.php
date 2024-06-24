<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryBrandRequest;
use Domain\Products\Actions\Categories\Brands\AssignBrandToCategory;
use Domain\Products\Actions\Categories\Brands\RemoveBrandFromCategory;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryBrandsController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category->filteringBrands,
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryBrandRequest $request)
    {
        return response(
            AssignBrandToCategory::run($category, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Category $category, int $brandId)
    {
        return response(
            RemoveBrandFromCategory::run($category, $brandId),
            Response::HTTP_OK
        );
    }
}
