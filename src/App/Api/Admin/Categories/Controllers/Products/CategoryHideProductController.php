<?php

namespace App\Api\Admin\Categories\Controllers\Products;

use App\Api\Admin\Categories\Requests\CategoryProductRequest;
use Domain\Products\Actions\Categories\Products\HideProductFromCategory;
use Domain\Products\Actions\Categories\Products\StopHidingProductFromCategory;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryHideProductController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category->productsToHide,
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryProductRequest $request)
    {
        return response(
            HideProductFromCategory::run($category, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Category $category, int $productId)
    {
        return response(
            StopHidingProductFromCategory::run($category, $productId),
            Response::HTTP_OK
        );
    }
}
