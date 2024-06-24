<?php

namespace App\Api\Admin\Categories\Controllers\Settings;

use Domain\Modules\Actions\GetModuleSections;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategorySiteSettingModuleController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            GetModuleSections::run($request,config('module_template.default_category_module_template')),
            Response::HTTP_OK
        );
    }
}
