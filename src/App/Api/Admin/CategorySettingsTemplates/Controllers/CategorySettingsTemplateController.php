<?php

namespace App\Api\Admin\CategorySettingsTemplates\Controllers;

use App\Api\Admin\CategorySettingsTemplates\Requests\CategorySettingsTemplateRequest;
use Domain\Products\Actions\Categories\Settings\CreateCategorySettingTemplate;
use Domain\Products\Actions\Categories\Settings\ModifyCategorySettingTemplate;
use Domain\Products\Models\Category\CategorySettingsTemplate;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategorySettingsTemplateController extends AbstractController
{
    public function index()
    {
        return response(
            CategorySettingsTemplate::all(),
            Response::HTTP_OK
        );
    }
    public function store(CategorySettingsTemplateRequest $request)
    {
        return response(
            CreateCategorySettingTemplate::run($request),
            Response::HTTP_CREATED
        );
    }
    public function update(CategorySettingsTemplate $categorySettingsTemplate,CategorySettingsTemplateRequest $request)
    {
        return response(
            ModifyCategorySettingTemplate::run($categorySettingsTemplate,$request),
            Response::HTTP_CREATED
        );
    }
    public function show(CategorySettingsTemplate $categorySettingsTemplate)
    {
        return response(
            $categorySettingsTemplate,
            Response::HTTP_CREATED
        );
    }
    public function destroy(CategorySettingsTemplate $categorySettingsTemplate)
    {
        return response(
            $categorySettingsTemplate->delete(),
            Response::HTTP_OK
        );
    }
}
