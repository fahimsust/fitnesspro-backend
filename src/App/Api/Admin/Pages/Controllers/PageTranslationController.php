<?php

namespace App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageTranslationRequest;
use Domain\Content\Models\Pages\Page;
use Domain\Content\Models\Pages\PageTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageTranslationController extends AbstractController
{
    public function update(Page $page,int $language_id, PageTranslationRequest $request)
    {
        return response(
            $page->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'title' => $request->title,
                'url_name' => $request->url_name,
                'content' => $request->page_content,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $page_id,int $language_id)
    {
        return response(
            PageTranslation::where('page_id',$page_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
