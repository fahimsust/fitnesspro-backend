<?php

namespace App\Api\Admin\DisplayTemplates\Controllers;

use Domain\Sites\Models\Layout\DisplayTemplateType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DisplayTemplateTypeController extends AbstractController
{
    public function index()
    {
        return Response(
            DisplayTemplateType::all(),
            Response::HTTP_OK
        );
    }
}
