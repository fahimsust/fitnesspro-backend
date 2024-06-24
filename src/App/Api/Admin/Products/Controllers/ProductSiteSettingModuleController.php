<?php

namespace App\Api\Admin\Products\Controllers;

use Domain\Modules\Actions\GetModuleSections;
use Domain\Modules\Models\ModuleTemplate;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductSiteSettingModuleController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            GetModuleSections::run($request,config('module_template.default_product_module_template')),
            Response::HTTP_OK
        );
    }
}
