<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\UpdateSiteMetaDataRequest;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteMetaDataController extends AbstractController
{
    public function __invoke(Site $site, UpdateSiteMetaDataRequest $request)
    {
        $site->update(
            [
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_desc' => $request->meta_desc,
            ]
        );

        return response(
            $site,
            Response::HTTP_CREATED
        );
    }
}
