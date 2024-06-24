<?php

namespace App\Api\Admin\Attributes\Controllers;

use App\Api\Admin\Attributes\Requests\AttributeSetTranslationRequest;
use Domain\Products\Models\Attribute\AttributeSet;
use Domain\Products\Models\Attribute\AttributeSetTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeSetTranslationController extends AbstractController
{
    public function update(AttributeSet $attributeSet,int $language_id, AttributeSetTranslationRequest $request)
    {
        return response(
            $attributeSet->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'name' => $request->name,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $set_id,int $language_id)
    {
        return response(
            AttributeSetTranslation::where('set_id',$set_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
