<?php

namespace App\Api\Admin\Sites\Controllers;

use App\Api\Admin\Sites\Requests\SiteCategoryRequest;
use Domain\Sites\Actions\Categories\AddCategoryToSite;
use Domain\Sites\Actions\Categories\RemoveCategoryFromSite;
use Domain\Sites\Models\Site;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SiteCategoryController extends AbstractController
{
    public function index(Site $site)
    {
        return response(
            $site->categories()->get(),
            Response::HTTP_OK
        );
    }

    public function store(Site $site, SiteCategoryRequest $request)
    {
        return response(
            AddCategoryToSite::run($site, $request),
            Response::HTTP_CREATED
        );
    }

    public function destroy(Site $site, int $cateryId)
    {
        return response(
            RemoveCategoryFromSite::run($site, $cateryId),
            Response::HTTP_OK
        );
    }
}
