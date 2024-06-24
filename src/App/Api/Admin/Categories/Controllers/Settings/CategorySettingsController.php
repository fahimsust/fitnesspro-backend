<?php

namespace App\Api\Admin\Categories\Controllers\Settings;

use App\Api\Admin\Categories\Requests\CategorySettingsRequest;
use Domain\Products\Actions\Categories\Settings\UpdateCategorySettingsTemplate;
use Domain\Products\Models\Category\Category;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategorySettingsController extends AbstractController
{
    public function index(Category $category){
        return response(
            $category->settings,
            Response::HTTP_OK
        );
    }
    public function store(Category $category, CategorySettingsRequest $request)
    {
        return response(
            UpdateCategorySettingsTemplate::run($category, $request),
            Response::HTTP_CREATED
        );
    }
}
