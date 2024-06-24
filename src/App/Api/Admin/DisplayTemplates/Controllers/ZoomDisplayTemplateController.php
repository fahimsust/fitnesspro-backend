<?php

namespace App\Api\Admin\DisplayTemplates\Controllers;

use Domain\Sites\Models\Layout\DisplayTemplateType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ZoomDisplayTemplateController extends AbstractController
{
    public function index()
    {
        return Response
        (
            DisplayTemplateType::find(config('display_templates.product_zoom'))->templates,
            Response::HTTP_OK
        );
    }
}
