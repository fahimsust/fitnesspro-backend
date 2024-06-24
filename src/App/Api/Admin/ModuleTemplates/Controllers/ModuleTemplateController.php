<?php

namespace App\Api\Admin\ModuleTemplates\Controllers;

use App\Api\Admin\ModuleTemplates\Requests\ModuleTemplateRequest;
use Domain\Modules\Actions\DeleteModuleTemplate;
use Domain\Modules\Models\ModuleTemplate;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ModuleTemplateController extends AbstractController
{
    public function index()
    {
        return Response(
            ModuleTemplate::all(),
            Response::HTTP_OK
        );
    }
    public function store(ModuleTemplateRequest $request)
    {
        return Response(
            ModuleTemplate::create($request->all()),
            Response::HTTP_CREATED
        );
    }
    public function update(ModuleTemplateRequest $request, ModuleTemplate $moduleTemplate)
    {
        return Response(
            $moduleTemplate->update($request->all()),
            Response::HTTP_CREATED
        );
    }
    public function show(int $module_template_id)
    {
        return Response(
            ModuleTemplate::whereId($module_template_id)
                ->with([
                    'moduleTemplateSections' => function ($query) {
                        $query->orderBy('id', 'desc');
                    },
                    'moduleTemplateSections.modulesTemplatesModules',
                    'moduleTemplateSections.layoutSection',
                    'moduleTemplateSections.modulesTemplatesModules.module',
                ])
                ->first(),
            Response::HTTP_OK
        );
    }
    public function destroy(ModuleTemplate $moduleTemplate)
    {
        return Response(
            DeleteModuleTemplate::run($moduleTemplate),
            Response::HTTP_OK
        );
    }
}
