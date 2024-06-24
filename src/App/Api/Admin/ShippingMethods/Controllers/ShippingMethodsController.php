<?php

namespace App\Api\Admin\ShippingMethods\Controllers;

use Domain\Orders\Models\Shipping\ShippingMethod;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShippingMethodsController extends AbstractController
{
    /**
     * Handle the incoming request.s
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(
            ShippingMethod::select('id', 'name')->get(),
            Response::HTTP_OK
        );
    }
}
