<?php

namespace App\Api\Admin\BulkEdit\Controllers;

use App\Api\Admin\BulkEdit\Requests\FindRequest;
use Domain\Products\Enums\BulkEdit\SearchOptions;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FindController extends AbstractController
{
    public function index()
    {
        return response(
            SearchOptions::options(),
            Response::HTTP_OK
        );
    }
    public function store(FindRequest $request)
    {
        return response(
            SearchOptions::tryFrom($request->search_option)->action()::run($request),
            Response::HTTP_OK
        );

    }
}
