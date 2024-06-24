<?php

namespace Domain\Modules\Actions;

use Domain\Modules\Models\ModuleTemplateModule;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteModuleTemplateModule
{
    use AsObject;

    public function handle(
        ModuleTemplateModule $moduleTemplateModule
    ): bool {

        $moduleTemplateModule->delete();
        return true;
    }
}
