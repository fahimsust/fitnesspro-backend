<?php

namespace App\Api\Admin\ModuleTemplates\Controllers;

use App\Api\Admin\ModuleTemplates\Requests\ModuleTemplateModuleRankRequest;
use App\Api\Admin\ModuleTemplates\Requests\ModuleTemplateModuleRequest;
use Domain\Modules\Actions\DeleteModuleTemplateModule;
use Domain\Modules\Models\ModuleTemplateModule;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ModuleTemplateModuleController extends AbstractController
{
    public function index(Request $request)
    {
        return Response(
            ModuleTemplateModule::whereTemplateId($request->template_id)
                ->whereSectionId($request->section_id)
                ->get(),
            Response::HTTP_OK
        );
    }
    public function store(ModuleTemplateModuleRequest $request)
    {
        return Response(
            ModuleTemplateModule::create($request->all()),
            Response::HTTP_CREATED
        );
    }
    public function update(ModuleTemplateModuleRankRequest $request, ModuleTemplateModule $moduleTemplateModule)
    {
        return Response(
            $moduleTemplateModule->update(
                [
                    "rank" => $request->rank,
                ]
            ),
            Response::HTTP_OK
        );
    }
    public function destroy(ModuleTemplateModule $moduleTemplateModule)
    {
        return Response(
            DeleteModuleTemplateModule::run($moduleTemplateModule),
            Response::HTTP_OK
        );
    }
}
