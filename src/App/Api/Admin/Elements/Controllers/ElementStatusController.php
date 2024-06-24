<?php

namespace App\Api\Admin\Elements\Controllers;

use App\Api\Admin\Elements\Requests\ElementStatusRequest;
use Domain\Content\Models\Element;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ElementStatusController extends AbstractController
{
    public function __invoke(Element $element, ElementStatusRequest $request)
    {
        $element->update(
            [
                'status' => $request->status,
            ]
        );
        return response(
            $element,
            Response::HTTP_CREATED
        );
    }
}
