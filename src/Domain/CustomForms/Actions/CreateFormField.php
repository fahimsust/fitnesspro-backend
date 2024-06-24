<?php

namespace Domain\CustomForms\Actions;

use App\Api\Admin\CustomForms\Requests\FormSectionFieldRequest;
use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\FormSectionField;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateFormField
{
    use AsObject;

    public function handle(
        FormSectionFieldRequest $request
    ): FormSectionField {

        $customField = CustomField::create([
            'display'=>$request->display,
            'name'=>$request->name,
            'rank'=>0,
            'status'=>1,
        ]);

        return FormSectionField::create([
            'section_id'=> $request->section_id,
            'field_id'=> $customField->id,
            'required'=> 0,
            'rank'=> 0,
            'new_row'=> 0,
        ]);
    }
}
