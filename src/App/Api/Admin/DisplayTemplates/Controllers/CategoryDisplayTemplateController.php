<?php

namespace App\Api\Admin\DisplayTemplates\Controllers;

use Domain\Sites\Models\Layout\DisplayTemplateType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryDisplayTemplateController extends AbstractController
{
    public function index()
    {
        return Response
        (
            DisplayTemplateType::find(config('display_templates.category_thumbnail'))->templates,
            Response::HTTP_OK
        );
    }
}
