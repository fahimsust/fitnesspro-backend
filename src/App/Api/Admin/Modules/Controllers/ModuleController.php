<?php

namespace App\Api\Admin\Modules\Controllers;

use Domain\Modules\Models\Module;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ModuleController extends AbstractController
{
    public function index()
    {
        return Response(
            Module::all(),
            Response::HTTP_OK
        );
    }
}
