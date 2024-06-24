<?php

namespace App\Api\Admin\Sites\Controllers;

use Domain\Modules\Actions\GetModuleSections;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteSettingModuleController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            GetModuleSections::run($request,config('module_template.default_site_module_template')),
            Response::HTTP_OK
        );
    }
}
