<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\CreateSiteRequest;
use App\Api\Admin\Sites\Requests\UpdateSiteRequest;
use Domain\Sites\Actions\CreateSite;
use Domain\Sites\Actions\UpdateSite;
use Domain\Sites\Models\Site;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends AbstractController
{
    public function index(Request $request)
    {
        return response(
            Site::query()
            ->search($request)
            ->get(),
            Response::HTTP_OK,
        );
    }

    public function store(CreateSiteRequest $request)
    {
        return response(
            CreateSite::run($request),
            Response::HTTP_CREATED
        );
    }

    public function update(Site $site, UpdateSiteRequest $request)
    {
        return response(
            UpdateSite::run($site, $request),
            Response::HTTP_CREATED
        );
    }
    public function show(Site $site)
    {
        return response(
            $site,
            Response::HTTP_CREATED
        );
    }

//    public function destroy(Site $site)
//    {
//        return response(
//            $site->delete(),
//            Response::HTTP_OK
//        );
//    }
}
