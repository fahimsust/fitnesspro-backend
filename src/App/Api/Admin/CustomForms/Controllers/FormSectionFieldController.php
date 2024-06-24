<?php

namespace App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\FormSectionFieldRequest;
use App\Api\Admin\CustomForms\Requests\FormSectionFieldUpdateRequest;
use Domain\CustomForms\Actions\CreateFormField;
use Domain\CustomForms\Models\FormSectionField;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FormSectionFieldController extends AbstractController
{
    public function store(FormSectionFieldRequest $request)
    {
        return response(
            CreateFormField::run($request),
            Response::HTTP_CREATED
        );
    }

    public function update(FormSectionField $customFormField, FormSectionFieldUpdateRequest $request)
    {
        return response(
            $customFormField->update([
                'required' => $request->required,
                'rank' => $request->rank,
                'new_row'=>$request->new_row
            ]),
            Response::HTTP_CREATED
        );
    }

    public function destroy(FormSectionField $customFormField)
    {
        return response(
            $customFormField->delete(),
            Response::HTTP_OK
        );
    }
}
