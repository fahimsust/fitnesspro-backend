<?php

namespace App\Api\Admin\Categories\Controllers\Settings;

use App\Api\Admin\Categories\Requests\CategorySiteSettingsRequest;
use Domain\Products\Actions\Categories\Settings\GetSiteSettingsForCategory;
use Domain\Products\Actions\Categories\Settings\UpdateCategorySettingsTemplateForSite;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategorySiteSettingsController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            GetSiteSettingsForCategory::run($category),
            Response::HTTP_OK
        );
    }
    public function store(
        Category $category,
        CategorySiteSettingsRequest $request
    ) {
        return response(
            UpdateCategorySettingsTemplateForSite::run($category, $request),
            Response::HTTP_CREATED
        );
    }
}
