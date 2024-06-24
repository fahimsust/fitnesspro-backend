<?php

namespace App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeTranslationRequest;
use Domain\Products\Models\Attribute\Attribute;
use Domain\Products\Models\Attribute\AttributeTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeTranslationController extends AbstractController
{
    public function update(Attribute $attribute,int $language_id, AttributeTranslationRequest $request)
    {
        return response(
            $attribute->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'name' => $request->name,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $attribute_id,int $language_id)
    {
        return response(
            AttributeTranslation::where('attribute_id',$attribute_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
