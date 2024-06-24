<?php

namespace App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqCategoryTranslationRequest;
use Domain\Content\Models\Faqs\FaqCategory;
use Domain\Content\Models\Faqs\FaqCategoryTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FaqCategoryTranslationController extends AbstractController
{
    public function update(FaqCategory $faqCategory,int $language_id, FaqCategoryTranslationRequest $request)
    {
        return response(
            $faqCategory->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'title' => $request->title
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $categories_id,int $language_id)
    {
        return response(
            FaqCategoryTranslation::where('categories_id',$categories_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
