<?php

namespace App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeOptionTranslationRequest;
use Domain\Products\Models\Attribute\AttributeOption;
use Domain\Products\Models\Attribute\AttributeOptionTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeOptionTranslationController extends AbstractController
{
    public function update(AttributeOption $attributeOption,int $language_id, AttributeOptionTranslationRequest $request)
    {
        return response(
            $attributeOption->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'display' => $request->display,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $option_id,int $language_id)
    {
        return response(
            AttributeOptionTranslation::where('option_id',$option_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
