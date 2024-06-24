<?php

namespace App\Api\Admin\Categories\Controllers\Products;

use App\Api\Admin\Categories\Requests\CategoryProductRankRequest;
use App\Api\Admin\Categories\Requests\CategoryProductRequest;
use Domain\Products\Actions\Categories\Products\RemoveShowProductInCategory;
use Domain\Products\Actions\Categories\Products\ShowProductInCategory;
use Domain\Products\Actions\Categories\Products\UpdateCategoryShowProduct;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryShowProductController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category->productsToShow,
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryProductRequest $request)
    {
        return response(
            ShowProductInCategory::run($category, $request),
            Response::HTTP_CREATED
        );
    }
    public function update(Category $category, int $productId,CategoryProductRankRequest $request )
    {
        return response(
            UpdateCategoryShowProduct::run($category, $productId,$request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Category $category, int $productId)
    {
        return response(
            RemoveShowProductInCategory::run($category, $productId),
            Response::HTTP_OK
        );
    }
}
