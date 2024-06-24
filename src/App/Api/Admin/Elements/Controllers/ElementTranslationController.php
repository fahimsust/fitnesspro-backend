<?php

namespace App\Api\Admin\Elements\Controllers;

use App\Api\Admin\Elements\Requests\ElementTranslationRequest;
use Domain\Content\Models\Element;
use Domain\Content\Models\ElementTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ElementTranslationController extends AbstractController
{
    public function update(Element $element,int $language_id, ElementTranslationRequest $request)
    {
        return response(
            $element->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'content' => $request->element_content,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $element_id,int $language_id)
    {
        return response(
            ElementTranslation::where('element_id',$element_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
