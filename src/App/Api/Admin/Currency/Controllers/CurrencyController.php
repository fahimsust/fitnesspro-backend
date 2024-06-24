<?php

namespace App\Api\Admin\Currency\Controllers;

use Domain\Locales\Models\Currency;
use Illuminate\Http\Request;
use Support\Controllers\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends AbstractController
{
    public function index(Request $request)
    {
        return Response
        (
            Currency::where('status',true)->search($request)->get(),
            Response::HTTP_OK
        );
    }
    public function show(Currency $currency)
    {
        return Response
        (
            $currency,
            Response::HTTP_OK
        );
    }
}
