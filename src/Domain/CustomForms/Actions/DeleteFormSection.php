<?php

namespace Domain\CustomForms\Actions;

use Domain\CustomForms\Models\FormSection;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteFormSection
{
    use AsObject;

    public function handle(
        FormSection $formSection
    ): bool {
        $formSection->delete();
        return true;
    }
}
