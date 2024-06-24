<?php

namespace App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageTranslationMetaDataRequest;
use Domain\Content\Models\Pages\Page;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageTranslationMetaDataController extends AbstractController
{
    public function update(Page $page,int $language_id,  PageTranslationMetaDataRequest $request)
    {
        return response(
            $page->translations()->updateOrCreate(
                [
                    'language_id'=>$language_id
                ],
                [
                    'meta_title' => $request->meta_title,
                    'meta_description' => $request->meta_description,
                    'meta_keywords' => $request->meta_keywords,
                ]),
            Response::HTTP_CREATED
        );
    }
}
