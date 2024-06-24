<?php

namespace App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\FieldTranslationRequest;
use Domain\CustomForms\Models\CustomField;
use Domain\CustomForms\Models\CustomFieldTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FieldTranslationController extends AbstractController
{
    public function update(CustomField $customField, int $language_id, FieldTranslationRequest $request)
    {
        return response(
            $customField->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'display' => $request->display,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $field_id,int $language_id)
    {
        return response(
            CustomFieldTranslation::where('field_id',$field_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
