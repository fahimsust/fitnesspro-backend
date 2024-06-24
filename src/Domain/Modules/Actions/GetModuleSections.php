<?php

namespace Domain\Modules\Actions;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Modules\Models\ModuleTemplateSection;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsObject;

class GetModuleSections
{
    use AsObject;

    public function handle(
        Request $request,
        int $defaultId
    ) {
        $moduleTemplate = ModuleTemplate::find($request->module_template_id?$request->module_template_id:$defaultId);
        $moduleSectionModules = [];
        $moduleIds = $moduleTemplate->getAllParentIdWithSelfId();

        $moduleSections = ModuleTemplateSection::whereIn('template_id', $moduleIds)
            ->join('display_sections', 'display_sections.id', '=', 'modules_templates_sections.section_id')
            ->groupBy('section_id')->orderBy('display_sections.rank', 'ASC')->get();

        foreach ($moduleSections as $moduleSection) {
            $moduleTemplateModules = ModuleTemplateModule::whereIn('template_id', $moduleIds)
                ->where('section_id', $moduleSection->section_id)->with('module')
                ->orderBy('rank', 'ASC')->groupBy("module_id")->get();
            $moduleSectionModules[] = [
                'sections' => $moduleSection,
                'modules' => $moduleTemplateModules
            ];
        }
        return $moduleSectionModules;
    }
}
