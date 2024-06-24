<?php

namespace App\Api\Admin\Products\Controllers;

use Domain\Products\Models\Product\ProductAvailability;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductAvailabilitiesController extends AbstractController
{
    public function __invoke(Request $request)
    {
        return response(
            ProductAvailability::search($request)->orderBy('name')->get(),
            Response::HTTP_OK
        );
    }
}
