<?php

namespace Domain\CustomForms\Actions;

use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\ProductFormType;
use Lorisleiva\Actions\Concerns\AsObject;

class DeleteCustomForm
{
    use AsObject;

    public function handle(
        CustomForm $customForm
    ): bool {
        ProductFormType::whereFormId($customForm->id)->delete();
        $customForm->delete();
        return true;
    }
}
