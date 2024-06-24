<?php

namespace App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\FormTranslationRequest;
use Domain\CustomForms\Models\CustomForm;
use Domain\CustomForms\Models\CustomFormTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FormTranslationController extends AbstractController
{
    public function update(CustomForm $customForm,int $language_id, FormTranslationRequest $request)
    {
        return response(
            $customForm->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'name' => $request->name,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $form_id,int $language_id)
    {
        return response(
            CustomFormTranslation::where('form_id',$form_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
