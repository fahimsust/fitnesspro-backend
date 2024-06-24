<?php

namespace App\Api\Admin\CustomForms\Controllers;

use App\Api\Admin\CustomForms\Requests\SectionTranslationRequest;
use Domain\CustomForms\Models\FormSection;
use Domain\CustomForms\Models\FormSectionTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SectionTranslationController extends AbstractController
{
    public function update(FormSection $formSection,int $language_id, SectionTranslationRequest $request)
    {
        return response(
            $formSection->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'title' => $request->title,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $section_id,int $language_id)
    {
        return response(
            FormSectionTranslation::where('section_id',$section_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
