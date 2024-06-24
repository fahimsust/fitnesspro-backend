<?php

namespace App\Api\Admin\PaymentMethods\Controllers;

use Domain\Payments\Models\PaymentMethod;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PaymentMethodController extends AbstractController
{
    public function index()
    {
        return response(
            PaymentMethod::where('status',1)->orderBy('name')->get(),
            Response::HTTP_OK
        );
    }
}
