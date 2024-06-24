<?php

namespace App\Api\Admin\Layouts\Controllers;

use Domain\Sites\Models\Layout\Layout;
use Domain\Sites\Models\Layout\LayoutSection;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LayoutSectionController extends AbstractController
{
    public function index()
    {
        return Response(
            LayoutSection::all(),
            Response::HTTP_OK
        );
    }
}
