<?php

namespace App\Api\Admin\Categories\Controllers\Settings;

use App\Api\Admin\Categories\Requests\CategoryMenuSettingsRequest;
use Domain\Products\Actions\Categories\Settings\UpdateCategoryMenuSettings;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryMenuSettingsController extends AbstractController
{
    public function index(Category $category)
    {
        return response(
            $category,
            Response::HTTP_OK
        );
    }

    public function store(Category $category, CategoryMenuSettingsRequest $request)
    {
        return response(
            UpdateCategoryMenuSettings::run($category, $request),
            Response::HTTP_CREATED
        );
    }
}
