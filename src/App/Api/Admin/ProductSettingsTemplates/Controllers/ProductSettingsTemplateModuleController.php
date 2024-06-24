<?php

namespace App\Api\Admin\ProductSettingsTemplates\Controllers;

use Domain\Modules\Actions\GetModuleSections;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSettingsTemplateModuleController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            GetModuleSections::run($request,config('module_template.default_product_setting_module_template')),
            Response::HTTP_OK
        );
    }
}
