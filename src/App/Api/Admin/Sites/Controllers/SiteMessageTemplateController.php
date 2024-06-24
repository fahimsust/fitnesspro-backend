<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteMessageTemplateRequest;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteMessageTemplateController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->messageTemplate,
            Response::HTTP_OK
        );
    }

    public function store(Site $site, SiteMessageTemplateRequest $request)
    {
        $site->messageTemplate()->update(
            [
                'html' => $request->html,
                'alt' => $request->alt,
            ]
        );

        return response(
            $site->messageTemplate,
            Response::HTTP_CREATED
        );
    }
}
