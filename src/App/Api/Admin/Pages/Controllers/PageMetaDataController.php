<?php

namespace App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageMetaDataRequest;
use Domain\Content\Models\Pages\Page;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageMetaDataController extends AbstractController
{
    public function __invoke(Page $page, PageMetaDataRequest $request)
    {
        $page->update(
            [
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]
        );
        return response(
            $page->refresh(),
            Response::HTTP_CREATED
        );
    }
}
