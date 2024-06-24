<?php

namespace Domain\Modules\Actions;

use Domain\Modules\Models\ModuleTemplateModule;
use Domain\Modules\Models\ModuleTemplateSection;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteModuleTemplateSection
{
    use AsObject;

    public function handle(
        ModuleTemplateSection $moduleTemplateSection
    ): bool {
        $moduleTemplateModules = ModuleTemplateModule::where('template_id', $moduleTemplateSection->template_id)
            ->where('section_id', $moduleTemplateSection->section_id)
            ->get();

        foreach ($moduleTemplateModules as $moduleTemplateModule) {
            DeleteModuleTemplateModule::run($moduleTemplateModule);
        }

        $moduleTemplateSection->delete();
        return true;
    }
}
