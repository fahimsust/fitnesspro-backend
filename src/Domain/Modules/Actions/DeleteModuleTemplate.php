<?php

namespace Domain\Modules\Actions;

use Domain\Modules\Models\ModuleTemplate;
use Domain\Modules\Models\ModuleTemplateSection;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteModuleTemplate
{
    use AsObject;

    public function handle(
        ModuleTemplate $moduleTemplate
    ): bool {

        $moduleTemplateSections = ModuleTemplateSection::where('template_id', $moduleTemplate->id)
            ->get();
        foreach ($moduleTemplateSections as $moduleTemplateSection) {
            DeleteModuleTemplateSection::run($moduleTemplateSection);
        }
        $moduleTemplate->delete();

        return true;
    }
}
