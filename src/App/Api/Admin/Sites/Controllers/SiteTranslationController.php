<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteTranslationRequest;
use Domain\Sites\Models\Site;
use Domain\Sites\Models\SiteTranslation;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteTranslationController extends AbstractController
{
    public function update(Site $site,int $language_id, SiteTranslationRequest $request)
    {
        return response(
            $site->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_desc' => $request->meta_desc,
            ]),
            Response::HTTP_CREATED
        );
    }

    public function show(int $site_id,int $language_id)
    {
        return response(
            SiteTranslation::where('site_id',$site_id)->where('language_id',$language_id)->first(),
            Response::HTTP_OK
        );
    }
}
