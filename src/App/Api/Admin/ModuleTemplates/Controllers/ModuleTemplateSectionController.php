<?php

namespace App\Api\Admin\ModuleTemplates\Controllers;


use App\Api\Admin\ModuleTemplates\Requests\ModuleTemplateSectionRequest;
use Domain\Modules\Actions\DeleteModuleTemplateSection;
use Domain\Modules\Models\ModuleTemplateSection;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ModuleTemplateSectionController extends AbstractController
{
    public function index(Request $request)
    {
        return Response(
            ModuleTemplateSection::whereTemplateId($request->template_id)->get(),
            Response::HTTP_OK
        );
    }
    public function store(ModuleTemplateSectionRequest $request)
    {
        return Response(
            ModuleTemplateSection::create($request->all()),
            Response::HTTP_CREATED
        );
    }
    public function destroy(ModuleTemplateSection $moduleTemplateSection)
    {
        return Response(
            DeleteModuleTemplateSection::run($moduleTemplateSection),
            Response::HTTP_OK
        );
    }
}
