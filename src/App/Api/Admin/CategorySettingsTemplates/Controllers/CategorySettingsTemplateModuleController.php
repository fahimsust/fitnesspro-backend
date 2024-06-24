<?php

namespace App\Api\Admin\CategorySettingsTemplates\Controllers;

use Domain\Modules\Actions\GetModuleSections;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategorySettingsTemplateModuleController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            GetModuleSections::run($request,config('module_template.default_category_setting_module_template')),
            Response::HTTP_OK
        );
    }
}
