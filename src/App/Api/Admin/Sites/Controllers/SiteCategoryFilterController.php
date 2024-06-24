<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteCategoryFilterRequest;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteCategoryFilterController extends AbstractController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Site $site, SiteCategoryFilterRequest $request)
    {
        $site->settings()->update(
            [
                'filter_categories' => $request->filter_categories,
            ]
        );
        return response(
            $site->settings,
            Response::HTTP_CREATED
        );
    }
}
