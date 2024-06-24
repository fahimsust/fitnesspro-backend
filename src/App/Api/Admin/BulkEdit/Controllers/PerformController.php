<?php

namespace App\Api\Admin\BulkEdit\Controllers;

use App\Api\Admin\BulkEdit\Requests\PerformRequest;
use Domain\Products\Enums\BulkEdit\ActionList;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PerformController extends AbstractController
{
    public function index()
    {
        return response(
            ActionList::options(),
            Response::HTTP_OK
        );
    }
    public function store(PerformRequest $request)
    {
        return response(
            ActionList::getByValue($request->action_name)->action()::run($request),
            Response::HTTP_OK
        );

    }
}
