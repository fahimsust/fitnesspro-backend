<?php

namespace App\Api\Admin\Faqs\Controllers;

use App\Api\Admin\Faqs\Requests\FaqTranslationRequest;
use Domain\Content\Models\Faqs\Faq;
use Domain\Content\Models\Faqs\FaqTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FaqTranslationController extends AbstractController
{
    public function update(Faq $faq,int $language_id, FaqTranslationRequest $request)
    {
        return response(
            $faq->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'question' => $request->question,
                'answer' => $request->answer
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $faqs_id,int $language_id)
    {
        return response(
            FaqTranslation::where('faqs_id',$faqs_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
