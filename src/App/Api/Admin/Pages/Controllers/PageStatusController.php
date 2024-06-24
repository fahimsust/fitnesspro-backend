<?php

namespace App\Api\Admin\Pages\Controllers;

use App\Api\Admin\Pages\Requests\PageStatusRequest;
use Domain\Content\Models\Pages\Page;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PageStatusController extends AbstractController
{
    public function __invoke(Page $page, PageStatusRequest $request)
    {
        $page->update(
            [
                'status' => $request->status,
            ]
        );
        return response(
            $page->refresh(),
            Response::HTTP_CREATED
        );
    }
}
