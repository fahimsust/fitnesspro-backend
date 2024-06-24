<?php

namespace App\Api\Admin\Products\Types\Controllers;

use Domain\Products\Actions\Types\GetProductTypeWithSelectedSetAndTax;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductTypesController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            GetProductTypeWithSelectedSetAndTax::run($request),
            Response::HTTP_OK
        );
    }
}
