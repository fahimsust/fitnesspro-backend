<?php

namespace App\Api\Admin\Categories\Controllers;

use App\Api\Admin\Categories\Requests\CategoryProductRankRequest;
use App\Api\Admin\Categories\Requests\CategoryProductRequest;
use Domain\Products\Actions\Categories\FeaturedProducts\FeatureProductInCategory;
use Domain\Products\Actions\Categories\FeaturedProducts\StopFeaturingProductInCategory;
use Domain\Products\Actions\Categories\FeaturedProducts\UpdateCategoryFeaturedProduct;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryFeatureProductController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category->featuredProducts,
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryProductRequest $request)
    {
        return response(
            FeatureProductInCategory::run($category, $request),
            Response::HTTP_CREATED
        );
    }
    public function update(Category $category, int $productId,CategoryProductRankRequest $request )
    {
        return response(
            UpdateCategoryFeaturedProduct::run($category, $productId,$request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Category $category, int $productId)
    {
        return response(
            StopFeaturingProductInCategory::run($category, $productId),
            Response::HTTP_OK
        );
    }
}
