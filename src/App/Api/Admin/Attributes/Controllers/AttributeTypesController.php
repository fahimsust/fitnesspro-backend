<?php

namespace App\Api\Admin\Attributes\Controllers;

use Domain\Products\Models\Attribute\AttributeType;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AttributeTypesController extends AbstractController
{
    public function index()
    {
        return response(
            AttributeType::all(),
            Response::HTTP_OK
        );
    }
}
