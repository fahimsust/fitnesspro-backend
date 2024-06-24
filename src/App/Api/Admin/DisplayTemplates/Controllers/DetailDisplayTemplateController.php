<?php

namespace App\Api\Admin\DisplayTemplates\Controllers;

use Domain\Sites\Models\Layout\DisplayTemplateType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DetailDisplayTemplateController extends AbstractController
{
    public function index()
    {
        return Response
        (
            DisplayTemplateType::find(config('display_templates.product_detail'))->templates,
            Response::HTTP_OK
        );
    }
}
