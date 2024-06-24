<?php

namespace App\Api\Admin\Categories\Controllers\Settings;

use App\Api\Admin\Categories\Requests\CategoryFilterSettingsRequest;
use Domain\Products\Actions\Categories\Settings\UpdateCategoryFilterSettings;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryFilterSettingsController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category,
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryFilterSettingsRequest $request)
    {
        return response(
            UpdateCategoryFilterSettings::run($category, $request),
            Response::HTTP_CREATED
        );
    }
}
