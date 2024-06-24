<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteOfflineMessageTranslationRequest;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteOfflineMessageTranslationController extends AbstractController
{
    public function update(Site $site,int $language_id, SiteOfflineMessageTranslationRequest $request)
    {
        return response(
            $site->translations()->updateOrCreate(
            [
                'language_id'=>$language_id
            ],
            [
                'offline_message' => $request->offline_message,
            ]),
            Response::HTTP_CREATED
        );
    }
}
